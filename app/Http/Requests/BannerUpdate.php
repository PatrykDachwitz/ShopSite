<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Rules\StringRule;
use Illuminate\Foundation\Http\FormRequest;

class BannerUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    public function getKeysFile() {
        $keysFilePc = array_keys($this->file['pc'] ?? []);
        $keysFileMobile = array_keys($this->file['mobile'] ?? []);
        $keysFile = [];

        foreach ($keysFilePc ?? [] as $key) {
            if(!is_null($this->file['pc'][$key])) $keysFile['pc'][] = $key;
        }

        foreach ($keysFileMobile ?? [] as $key) {
            if(!is_null($this->file['mobile'][$key])) $keysFile['mobile'][] = $key;
        }

        return $keysFile;
    }

    public function rules()
    {
        $ruleFile = [
            'file',
            'mimes:jpg,webp,jpeg,png,gif',
            'max:10240'
        ];
        $keysFile = $this->getKeysFile();

        $validoator = [];
        foreach ($keysFile as $device => $file ) {
            foreach ($file as $position) {
                $validoator = array_merge($validoator,[
                    "file.{$device}.{$position}" => $ruleFile
                ]);
            }
        }

        if(isset($this->availableFile['pc'])) {
            $radioPcKey = array_keys($this->availableFile['pc'])[0];
            $validoator = array_merge($validoator, [
                "availableFile.pc.{$radioPcKey}" => ['required', 'Integer', 'min:1']
            ]);
        }
        if(isset($this->availableFile['mobile'])) {
            $radioMobileKey = array_keys($this->availableFile['mobile'])[0];
            $validoator = array_merge($validoator, [
                "availableFile.mobile.{$radioMobileKey}" => ['required', 'Integer', 'min:1']
            ]);
        }

        $validoator = array_merge($validoator, [
            'id' => ['required', 'Integer', "min:0", 'max:1550'],
            "name" => ['required', new StringRule(), 'min:3', 'max: 255'],
            "start-date" => ['required', 'date'],
            "end-date" => ['required', 'date'],
            "type" => ['required', 'Integer', 'min:1'],
            "active" => ['required', 'Boolean'],
            'position' => ['required', 'Integer', "min:1"],
            'contents' => ['required'],
        ]);

        return $validoator;
    }
}
