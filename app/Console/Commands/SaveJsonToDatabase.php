<?php

namespace App\Console\Commands;

use App\Repositories\Client\ActivityRepository;
use App\Repositories\Client\ImageRepository;
use App\Repositories\Client\TourGuiderRepository;
use App\Repositories\Client\TourRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SaveJsonToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'json:save-to-db {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read a JSON file and save its contents to the database';

    private TourRepository $tourRepository;
    private ImageRepository $imageRepository;
    private ActivityRepository $activityRepository;
    private TourGuiderRepository $tourGuiderRepository;


    /**
     * Execute the console command.
     */
    public function __construct(TourRepository $tourRepo, ImageRepository $imageRepo, ActivityRepository $activityRepo, TourGuiderRepository $tourGuiderRepo)
    {
        parent::__construct();
        $this->tourRepository = $tourRepo;
        $this->imageRepository = $imageRepo;
        $this->activityRepository = $activityRepo;
        $this->tourGuiderRepository = $tourGuiderRepo;
    }

    public function handle()
    {
        $filename = $this->argument('filename');
        $path = storage_path('app/' . $filename);

        if (!File::exists($path)) {
            $this->error('File not found');
            return 1;
        }

        $json = File::get($path);
        $data = json_decode($json, true);
        $data = $data['response']['listTour'];

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON');
            return 1;
        }

        $jsonDetail = File::get(storage_path('app/merged.json'));
        $details = json_decode($jsonDetail, true);
        
        foreach ($data as $index => $item) {
            $tour = $this->tourRepository->upsert([
                'matour' => $item['tourCode'],
            ], [
                'matour' => $item['tourCode'],
                'tieude' => $item['destination'],
                'noikh' => $item['departureName'],
                'gia_a' => $item['adultPrice'],
                'gia_c' => $item['adultPrice']*50/100,
                'anh' => $item['imageUrl'],
                'trangthai' => $item['tourLineTitle'],
            ]);

            foreach ($details as $index => $detail) {
                $data = $detail['data' . random_int(1, 4)];
                foreach ($data['listImageUrl'] as $index => $img) {
                    $this->imageRepository->create([
                        'matour' => $tour->id,
                        'nguon' => $img['imageUrl']
                    ]);
                }

                foreach ($data['listTourProgram'] as $index => $tourProgram) {
                    $this->activityRepository->upsert([
                        'matour' => $tour->id,
                    ],[
                        'matour' => $tour->id,
                        'stt' => $tourProgram['day'],
                        'ngay' => $tourProgram['date'],
                        'tieude' => $tourProgram['title'],
                        'mota' => $tourProgram['detail']
                    ]);
                }

                if ($data['tourGuide']) {
                    $this->tourGuiderRepository->upsert([
                        'ten' => $data['tourGuide']['fullName'],
                        'sdt' => $data['tourGuide']['phone'],
                    ], [
                        'ten' => $data['tourGuide']['fullName'],
                        'sdt' => $data['tourGuide']['phone'],
                        'diachi' => 'HCM',
                        'email' => null,
                        'anh' => null
                    ]);
                }

            }
            $this->info('Tour ' . ($index + 1) . ' added successfully: ' . $item['tourCode']);
        }

        $this->info('Data saved successfully');
        return 0;
    }



}