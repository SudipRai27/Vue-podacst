<?php

namespace App\Observers;

use App\Models\Podcast;
use App\Services\UploadService;
use App\Jobs\DeleteFiles;

class PodcastObserver
{
    public function created(Podcast $podcast)
    {
        if (request()->hasFile('file')) {
            $data = UploadService::uploadSingleFile(request()->file);
            $this->updatePodcast($podcast, $data);
        }
    }

    public function deleted(Podcast $podcast)
    {
        $this->deletePodcastUpload($podcast);
    }

    public function updated(Podcast $podcast)
    {

        if (request()->hasFile('file')) {
            $data = UploadService::uploadSingleFile(request()->file);
            $this->deletePodcastUpload($podcast);
            $this->updatePodcast($podcast, $data);
        }
    }

    public function deletePodcastUpload(Podcast $podcast)
    {
        $data['unique_folder_id'] = $podcast->unique_folder_id;
        $data['file_name'] = $podcast->filename;
        DeleteFiles::dispatch($data);
    }


    public function updatePodcast(Podcast $podcast, array $data)
    {
        $podcast->filename = $data['filename'];
        $podcast->file_url = $data['url'];
        $podcast->unique_folder_id = $data['unique_folder_id'];
        $podcast->saveQuietly();
    }
}