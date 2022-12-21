<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerCreate;
use App\Http\Requests\BannerUpdate;
use App\Repository\Admin\BannerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private const STORAGE_PATH = '/app/privateHtml/';
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepository) {
        $this->bannerRepository = $bannerRepository;
    }

    public function index()
    {

       // dd($this->bannerRepository->getAll());
        return View('admin.banner.index', [
            'banners' => $this->bannerRepository->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.banner.create', [
            'types' => $this->bannerRepository->getTypes(),
            'actualyDate' => date('Y-m-d')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerCreate $request)
    {

        $clearData = $request->validated();
        try{
            $nameFile = $this->bannerRepository->create($clearData);
            file_put_contents(storage_path(self::STORAGE_PATH . $nameFile), "");
        } catch (Exception) {
            abort(500);
        }

        return redirect()
            ->route('admin.banner.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {

        $linkCustomFile = storage_path(self::STORAGE_PATH . 'test.html');
        try {
            $banner = $this->bannerRepository->find($id);
            //$availableTypes = $this->bannerRepository->getTypes();
            if(!file_exists($linkCustomFile)) throw new Exception('file n`t exsist!');
            else $customHtml = file_get_contents($linkCustomFile);
        } catch (Exception) {
            abort(404);
        }
        return View('admin.banner.show', [
            'banner' => $banner,
            'contents' => $customHtml,
            //'availableTypes' => $availableTypes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {

        $linkCustomFile = storage_path(self::STORAGE_PATH . 'test.html');
        try {
            $banner = $this->bannerRepository->find($id);
            //$availableTypes = $this->bannerRepository->getTypes();
            if(!file_exists($linkCustomFile)) throw new Exception('file n`t exsist!');
            else $customHtml = file_get_contents($linkCustomFile);
        } catch (Exception) {
            abort(404);
        }

        return View('admin.banner.edit', [
            'banner' => $banner,
            'contents' => $customHtml,
            'types' => $this->bannerRepository->getTypes()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerUpdate $request, \App\Service\Image\BannerCreate $imageSave)
    {
        $images = [];
        $clearData = $request->validated();
        if (isset($clearData['file'])) {
            $images = $imageSave->uploude($clearData['file']);
        };

        //dd($request->validated());

        $this->bannerRepository->update($clearData, $images);
        return Redirect()
            ->route('admin.banner.edit', [
                'banner' => $clearData['id']
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
