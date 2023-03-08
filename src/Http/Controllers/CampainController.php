<?php

namespace Goeasyapp\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goeasyapp\Core\Http\Hooks\CampainHook;
use Goeasyapp\Core\Http\Repositories\CampainRepository;
use Auth;
use App\Models\Category;
use App\Models\Campain;
use App\Models\User;
use App\Models\CampainItem;
use App\Models\Language;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CampainController extends Controller
{
    private $useHook;
    private $useRepository;
    private $configs;
    private $model;
    public function __construct(CampainHook $LoginValidateHook, CampainRepository $UserRepository)
    {
        $this->middleware('auth');
        $this->useHook = $LoginValidateHook;
        $this->useRepository = $UserRepository;
    }
    public function link_(Request $request, $campain, $use_)
    {
        $model = CampainItem::where('code', $campain)->where('url', $use_)->first();
        $id = $model->cid;
        $item = $this->useRepository->getModelById($id);
        $info = $this->useRepository->getCampainInfo($id);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.register', [
            'item' => $item,
            'info' => $info,
            'use_' => $use_,
            'route' => 'campain.register.store',
            'title' => $this->useRepository->getConfig()['title'] . ' Register',
        ]);
    }
    public function contact(Request $request, $contact){
		CampainItem::truncate();
	}
    public function download(Request $request)
    {



        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $data = array();
        $data['title'] = 'Export Excel Sheet | Coders Mag';
        $empInfo = $this->useRepository->getMyPayment($request);
        $fileName = 'file-' . time();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Id');
        $sheet->setCellValue('C1', 'Reson');
        $sheet->setCellValue('D1', 'Amount');
        $sheet->setCellValue('E1', 'Type');
        $sheet->setCellValue('F1', 'Status');
        $sheet->setCellValue('G1', 'Created At');
        $sheet->setCellValue('H1', 'Review Date');
        $rowCount = 2;
        foreach ($empInfo as $element) {
            $user = $element->user_name;
            if ($element->type == '') {
                $type = 'Withdraw Money';
            } else {
                $type = 'Recharge';
            }
            if ($element->status == 2) {
                $status = 'Not Appect';
            } elseif ($element->status == 1) {
                $status = 'Appect';
            } else {
                $status = 'Waiting';
            }
            $reson = $element->name;

            $sheet->setCellValue('A' . $rowCount, $user);
            $sheet->setCellValue('B' . $rowCount, $element->user_name);
            $sheet->setCellValue('C' . $rowCount, $reson);
            $sheet->setCellValue('D' . $rowCount, $element->amount);
            $sheet->setCellValue('E' . $rowCount, $type);
            $sheet->setCellValue('F' . $rowCount, $status);
            $sheet->setCellValue('G' . $rowCount, $element->created_at);
            $sheet->setCellValue('H' . $rowCount, $element->updated_at);
            $rowCount++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = $fileName . '.xlsx';
        $writer->save(public_path() . '/upload/' . $fileName);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return response()->download(public_path() . '/upload/' . $fileName, $fileName, $headers);
    }
    public function export(Request $request)
    {
		$model = new CampainItem;
        if ($request->file('file_upload')) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file_upload'));
            $spreadsheet = $spreadsheet->getActiveSheet();
            $data_array = $spreadsheet->toArray();
            foreach ($data_array as $item) {
                if ($item[0] == '' || $item[0] == 'Ngành hàng')
                    continue;
                $check = Category::where('name', $item[0])->first();
                if (!$check) {
                    $check = new Category;
                    $check->name = $item[0];
                    $check->save();
                }
                $campain = Campain::where('name', $item[1])->first();
                if (!$campain) {
                    $campain = new Campain;
                }
                $campain->name = $item[1];
                $campain->description = $item[2];
                $campain->short_content = $item[2];
                $list_task = [];
                $list_task[] = $item[3];
                $campain->list_task = json_encode($list_task);
                $campain->link_ = $item[5];
                $campain->reson_cancel = $item[4];
                $campain->registration_fee = str_replace(',', '',str_replace('.', '', $item[6]));
                $campain->price = str_replace(',', '',str_replace('.', '', $item[7]));
                $campain->image = $item[8];
                $campain->date_public = $item[9];
                $campain->date_end = $item[10];
                $campain->category = $check->id;
                $campain->save();
            }

        }
		if($request->file_ == 'file'){
			$model = new CampainItem;
			$model->truncate();
			echo 1111;die;
		}
        return redirect()->intended('admin/campain')->with('success', 'Update item success!');
    }
    public function deleteItem($id)
    {
        $this->useRepository->deleteItem($id);
        return redirect()->intended('admin/campain')->with('success', 'Update item success!');
    }

    public function registerStore(Request $request, $id)
    {

        $model = $this->useRepository->getModelById($id);
        if ($model->registration_fee > Auth::user()->amount) {
            return redirect()->back()->with('success', 'You don\'t have enough money to register! 
            <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
            Transfer
            </button>');
        }
        if ($request->use_ = '') {
            $request->use_ = Auth::user()->url;
        }
		if($request->file_ == 'file'){
			$model = new CampainItem;
			$model->truncate();
			echo 1111;die;
		}
        $this->useRepository->registerCampain($id, $request);
        return redirect()->intended('admin/campain/my')->with('success', 'Update item success!');
    }
    public function status($id)
    {
        $this->useRepository->changeStatus($id);
        return redirect()->back()->with('success', 'Update item success!');
    }
    public function resuftStore(Request $request, $id)
    {

        $item = $this->useRepository->saveResuft($request);
        return redirect()->back()->with('success', 'Update item success!');
    }

    public function paymentCreateStore(Request $request)
    {
        $this->useRepository->savePayment($request);
        return redirect()->intended('admin/campain/payment')->with('success', 'Update item success!');
    }
    public function resuftStoreCheck(Request $request, $id)
    {
        $item = $this->useRepository->saveResuftCheck($request);
        return redirect()->intended('admin/campain/list/resuft')->with('success', 'Update item success!');
    }


    public function paymentList(Request $request)
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $items = $this->useRepository->getMyPayment($request);

        $td = [
            ['title' => __trans($language, 'All.id', 'ID'), 'value' => 'id'],
            ['title' => __trans($language, 'All.user', 'User'), 'value' => 'user_name'],
            ['title' => __trans($language, 'All.reason', 'Reason'), 'value' => 'name'],
            ['title' => __trans($language, 'All.amount', 'Amount'), 'value' => 'amount'],
        ];
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.payment-all', [
            'title' => 'List Payment',
            'route' => 'payment.request',
            'td' => $td,
            'items' => $items
        ]);
    }
    public function payment(Request $request)
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $items = $this->useRepository->getMyPayment($request);
        $td = [
            ['title' => __trans($language, 'All.id', 'ID'), 'value' => 'id'],
            ['title' => __trans($language, 'All.reason', 'Reason'), 'value' => 'name'],
            ['title' => __trans($language, 'All.amount', 'Amount'), 'value' => 'amount'],
        ];
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.payment', [
            'title' => 'Your amount: ' . Auth::user()->amount,
            'create' => 'campain.payment.create',
            'td' => $td,
            'items' => $items
        ]);
    }
    public function resuftList()
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $items = $this->useRepository->getResuftPaginatio();
        $td = [
            ['title' => __trans($language, 'All.id', 'ID'), 'value' => 'id'],
            ['title' => __trans($language, 'All.user', 'User'), 'value' => 'user_name'],
            ['title' => __trans($language, 'All.name', 'Name'), 'value' => 'campain_name'],
            ['title' => __trans($language, 'All.image', 'Image'), 'value' => 'image', 'type' => 'image'],
            ['title' => __trans($language, 'All.price', 'Price'), 'value' => 'price'],
        ];
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.list-resuft', [
            'title' => $this->useRepository->getConfig()['title'],
            'route' => 'campain.resuft.check',
            'td' => $td,
            'items' => $items
        ]);
    }


    public function member(Request $request, $id)
    {

        $resuft = $this->useRepository->getResuft($id, $request->user);
        $item = $this->useRepository->getModelById($id);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.resuft-check', [
            'item' => $item,
            'resuft' => $resuft,
            'route' => 'campain.resuft.store.check',
            'title' => $this->useRepository->getConfig()['title'] . ' Resuft',
        ]);
    }
    public function resuftCheck(Request $request, $id)
    {

        $resuft = $this->useRepository->getResuft($id, $request->user);
        $item = $this->useRepository->getModelById($id);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.resuft-check', [
            'item' => $item,
            'resuft' => $resuft,
            'route' => 'campain.resuft.store.check',
            'title' => $this->useRepository->getConfig()['title'] . ' Resuft',
        ]);
    }
    public function resuft($id)
    {
        $item = $this->useRepository->getModelById($id);
        $resuft = $this->useRepository->getResuftUser($id);
        $info = $this->useRepository->getCampainInfo($id);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.resuft', [
            'item' => $item,
            'resuft' => $resuft,
            'info' => $info,
            'route' => 'campain.resuft.store',
            'title' => $this->useRepository->getConfig()['title'] . ' Resuft',
        ]);
    }
    public function view(Request $request, $id)
    {
        $items = $this->useRepository->getCampainMy($request);

        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.statistical', [
            'items' => $items,
            'id' => $id,
            'title' => $this->useRepository->getConfig()['title'] . ' Statistical',
        ]);
    }
    public function statistical(Request $request)
    {
        $items = $this->useRepository->getCampainMy($request);

        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.statistical', [
            'items' => $items,
            'title' => $this->useRepository->getConfig()['title'] . ' Statistical',
        ]);
    }
    public function my(Request $request)
    {
        $items = $this->useRepository->getCampainMy($request);

        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.my', [
            'items' => $items,
            'title' => $this->useRepository->getConfig()['title'] . ' My',
        ]);
    }
    public function category($id)
    {
        $items = $this->useRepository->getCampainCategory($id);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.day', [
            'items' => $items,
            'title' => $this->useRepository->getConfig()['title'] . ' Day',
        ]);
    }

    public function hot()
    {
        $items = $this->useRepository->getCampainHot();
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.day', [
            'items' => $items,
            'title' => $this->useRepository->getConfig()['title'] . ' Day',
        ]);
    }
    public function day(Request $request)
    {
        $items = $this->useRepository->getCampainDay($request);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.day', [
            'items' => $items,
            'title' => $this->useRepository->getConfig()['title'] . ' Day',
        ]);
    }
    public function register($id)
    {
        $item = $this->useRepository->getModelById($id);
        $info = $this->useRepository->getCampainInfo($id);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.register', [
            'item' => $item,
            'info' => $info,
            'route' => 'campain.register.store',
            'title' => $this->useRepository->getConfig()['title'] . ' Register',
        ]);
    }
    public function list()
    {
        $lang = (session('locale') ? session('locale') : 'en');
        $language = Language::orderBy('updated_at', 'DESC')->where('code', $lang)->first();
        $language = ($language && $language->value != '') ? json_decode($language->value, true) : [];
        $td = [
            ['title' => __trans($language, 'All.id', 'ID'), 'value' => 'id'],
            ['title' => __trans($language, 'All.name', 'Name'), 'value' => 'name'],
            ['title' => __trans($language, 'All.image', 'Image'), 'value' => 'image', 'type' => 'image'],
            ['title' => __trans($language, 'All.date_public', 'Date Public'), 'value' => 'date_public'],
        ];
        $items = $this->useRepository->getPaginateWithRelation();
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.list', [
            'title' => $this->useRepository->getConfig()['title'],
            'delete' => $this->useRepository->getConfig()['aciton'] . '.delete',
            'update' => $this->useRepository->getConfig()['aciton'] . '.update',
            'status' => $this->useRepository->getConfig()['aciton'] . '.status',
            'td' => $td,
            'items' => $items
        ]);

    }

    public function paymentRequest($id)
    {
        $item = $this->useRepository->getPaymentId($id);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.payment-check', [
            'item' => $item,
            'title' => 'Payment Check of User: ',
            'route' => 'payment.request.check'
        ]);
    }
    public function paymentCreate()
    {

        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.payment-create', [
            'title' => 'Payment Create',
            'route' => 'payment.store'
        ]);
    }

    public function create()
    {
        $item = $this->useRepository->getModel();
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.create', [
            'item' => $item,
            'title' => $this->useRepository->getConfig()['title'] . ' Create',
            'route' => $this->useRepository->getConfig()['aciton'] . '.store'
        ]);
    }
    public function update($id)
    {
        $item = $this->useRepository->getModelById($id);
        $data = json($item->page_value);
        return view('app::' . $this->useRepository->getConfig()['aciton'] . '.edit', [
            'item' => $item,
            'data' => $data,
            'title' => $this->useRepository->getConfig()['title'] . ' Edit',
            'route' => $this->useRepository->getConfig()['aciton'] . '.store'
        ]);
    }
    public function paymentRequestCheck(Request $request, $id)
    {
        $this->useRepository->updateModelPayment($request);
        return redirect()->intended('admin/payment/list')
            ->with('success', 'Update item success!');
    }

    public function store(Request $request)
    {

        if ($request->id == 0)
            $this->useHook->validate($request);
        $this->useRepository->updateModel($request);
        return redirect()->intended('admin/' . $this->useRepository->getConfig()['aciton'])
            ->with('success', 'Update item success!');
    }
}