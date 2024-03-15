<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Hash;

require_once(ROOT . '/vendor/' . DS . '/barcode/vendor/autoload.php');

require_once(ROOT . '/vendor' . DS . 'PaymentTransactions' . DS . 'authorize-credit-card.php');

require_once(ROOT . '/vendor/' . DS . '/mpdf/vendor/' . 'autoload.php');

require_once(ROOT . '/vendor/' . DS . '/phpoffice/vendor/autoload.php');

use \PHPExcel_IOFactory;

require_once(ROOT . '/vendor/' . DS . '/phpoffice2/phpspreadsheet/src/Bootstrap.php');

use PhpOffice\PhpSpreadsheet\IOFactory; //Read excel data
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AppadminsController extends AppController {

    public function initialize() {



        parent::initialize();

        $this->loadComponent('Paginator');

        $this->loadComponent('Mpdf');

        $this->loadComponent('Custom');

        $this->loadComponent('Flash');

        $this->loadModel('Pages');

        $this->loadModel('InUsers');

        $this->loadModel('InProducts');

        $this->loadModel('InRack');

        $this->loadModel('InProductType');

        $this->loadModel('Settings');

        $this->loadModel('InColors');

        $this->loadModel('InProductLogs');

        $this->viewBuilder()->layout('admin');
    }

    public $paginate = ['limit' => 50];

    public function ajaxDltTbl() {



        $this->viewBuilder()->layout('');

        if ($this->request->session()->read('Auth.User.type') == 1) {



            if ($this->request->is('post')) {



                $data = $this->request->getData();

                $this->InProducts->deleteAll([1]);

                $this->InUsers->deleteAll(['id !=' => 1]);

                echo json_encode(['status' => 'success', 'url' => HTTP_ROOT . 'appadmins/empty_all_tables']);
            }
        }



        EXIT;
    }

    public function emptyAllTables($userid = null) {



        $tables = ConnectionManager::get('default')->schemaCollection()->listTables();

        $this->set(compact('tables'));
    }

    public function beforeFilter(Event $event) {



        $this->Auth->allow(['logout']);
    }

    // public function index($id = null) {
    //     $this->viewBuilder()->layout('admin');        
    //     $this->set(compact('paid_users', 'men_count', 'women_count', 'kid_count'));
    // }







    public function index($id = null) {



        $this->viewBuilder()->layout('admin');

        $empId = $this->request->session()->read('Auth.User.id');

        $brands_count = $this->InUsers->find('all')->where(['type' => 3])->count();

        $men_product_count = $this->InProducts->find('all')->where(['profile_type' => 1])->count();

        $women_product_count = $this->InProducts->find('all')->where(['profile_type' => 2])->count();

        $boy_product_count = $this->InProducts->find('all')->where(['profile_type' => 3])->count();

        $girl_product_count = $this->InProducts->find('all')->where(['profile_type' => 4])->count();

        $this->set(compact('men_product_count', 'brands_count', 'women_product_count', 'boy_product_count', 'girl_product_count', 'empId', 'id'));
    }

    public function profile($param = null) {



        $user_id = $this->request->session()->read('Auth.User.id');

        $rowname = $this->InUsers->find('all')->where(['InUsers.id' => $user_id])->first();

        $getCurPassword = $this->InUsers->find('all', ['fields' => ['password']])->where(['InUsers.id' => $user_id])->first();

        $settingsEmailTempletes = $this->Settings->find('all')->where(['Settings.type' => 2])->group('Settings.id');

        $row = $this->InUsers->find('all')->where(['InUsers.id' => $user_id])->first();

        $type = $this->request->session()->read('Auth.User.type');

        $this->viewBuilder()->layout('admin');

        $user = $this->InUsers->newEntity();

        if ($this->request->is('post')) {



            $data = $this->request->data;

            $user->id = $this->request->session()->read('Auth.User.id');

            if (!empty($data['changepassword']) == 'Change password') {



                if ($data['password'] != $data['cpassword']) {



                    $this->Flash->error(__('Password and Confirm password fields do not match'));

                    return $this->redirect(['action' => 'profile/changepassword']);
                } else {







                    $hasher = new DefaultPasswordHasher();

                    $data['password'] = $hasher->hash($data['password']);

                    $user = $this->InUsers->patchEntity($user, $data);

                    if ($this->InUsers->save($user)) {



                        $this->Flash->success(__('Password has been chaged successfully.'));

                        return $this->redirect(['action' => 'profile/changepassword']);
                    } else {



                        $this->Flash->error(__('Password could not be change. Please, try again.'));

                        return $this->redirect(['action' => 'profile/changepassword']);
                    }
                }
            } else if ($data['general'] == 'save') {



                $set = $this->request->data;

                foreach ($set as $kehfhy => $value) {



                    $condition = array('name' => $kehfhy);

                    $this->Settings->updateAll(['value' => $value], ['name' => $kehfhy]);
                }



                $this->Flash->success(__('Communication emaill has been updated successfully.'));

                $this->redirect(HTTP_ROOT . 'appadmins/profile/communication');
            } else {



                if (@$data['name'] == '') {



                    $this->Flash->error(__("Please enter your name"));
                } else if ($data['email'] == '') {



                    $this->Flash->error(__("Please enter your email"));
                } else {



                    if ($this->InUsers->save($user)) {



                        $this->Flash->success(__('The Profile has been update.'));

                        return $this->redirect(['action' => 'profile']);
                    } else {



                        $this->Flash->error(__('The Profile could not be update. Please, try again.'));
                    }
                }
            }
        }



        $settings = $this->Settings->find('all', ['order' => 'Settings.id DESC'])
                ->where(['Settings.type' => 1, 'Settings.is_active' => 1]);

        $this->set(compact('rowname', 'settings', 'settingsEmailTempletes', 'row', 'user', 'row', 'options', 'param', 'user_id'));
    }

    // public function delete($id = null, $table = null) {
    //     $getDetail = $this->$table->find('all')->where([$table . '.id' => $id])->first();
    //     $data = $this->$table->get($id);
    //     $dataDelete = $this->$table->delete($data);
    //     if ($table == 'InUsers') {
    //         $this->Flash->success(__('Users has been deleted.'));
    //         return $this->redirect(HTTP_ROOT . 'appadmins/view_staff');
    //     } 
    //     if ($table == 'InProducts') {
    //         $this->Flash->success(__('Products has been deleted.'));
    //         $this->redirect($this->referer());
    //         //return $this->redirect(HTTP_ROOT . 'appadmins/view_product');
    //     }else {
    //         $this->Flash->success(__('Data has been deleted successfully.'));
    //         $this->redirect($this->referer());
    //     }
    // }







    public function productDelete($id = null, $table = null, $profile = null) {



        $getDetail = $this->$table->find('all')->where([$table . '.id' => $id])->first();

        $data = $this->$table->get($id);

        if ($table == 'InProducts') {

//            $dataDelete = $this->$table->deleteAll(['prod_id' => $data->prod_id]);

            $dataDelete = $this->$table->updateAll(['available_status' => 2, 'match_status' => 1, 'is_deleted' => 1], ['prod_id' => $data->prod_id]);

            $last_update_products = $this->InProducts->find('all')->where(['prod_id' => $data->prod_id]);

            foreach ($last_update_products as $prod_liiii) {

                $newDtArr = [];

                $newDtArr['product_id'] = $prod_liiii->id;

                $newDtArr['user_id'] = $this->request->session()->read('Auth.User.id');

                $newDtArr['action'] = 'deleted';

                $newDtArr['created_on'] = date('Y-m-d H:i:s');

                $newDtRow = $this->InProductLogs->newEntity();

                $newDtRow = $this->InProductLogs->patchEntity($newDtRow, $newDtArr);

                $this->InProductLogs->save($newDtRow);
            }





            $this->Flash->success(__('Products has been deleted.'));

            return $this->redirect($this->referer());

            //return $this->redirect(HTTP_ROOT . 'appadmins/view_product');
        }





        $dataDelete = $this->$table->delete($data);

        if ($table == 'InUsers') {







            $this->Flash->success(__('Users has been deleted.'));

            return $this->redirect(HTTP_ROOT . 'appadmins/view_staff');
        }







        $this->Flash->success(__('Data has been deleted successfully.'));

        $this->redirect($this->referer());
    }

    public function delete($id = null, $tble = null, $profile = null) {



        if ($id) {



            if ($tble == 'InUsers') {



                $this->InUsers->deleteAll(['id' => $id]);

                $this->Flash->success(__('Data has been deleted successfully.'));

                $this->redirect(HTTP_ROOT . 'appadmins/view_staff/');
            } else {

                $list = $this->InProducts->find('all')->where(['id' => $id])->first();

                $this->InProducts->deleteAll(['prod_id' => $list->prod_id]);

                $this->Flash->success(__('Data has been deleted successfully.'));

                $this->redirect(HTTP_ROOT . 'appadmins/add_product/' . $profile);
            }
        }
    }

    public function productList($profile = null, $category = null) {

        $utype = $this->request->session()->read('Auth.User.type');

        $where_arr = [];

        if (!empty($category)) {

            $where_arr['product_type'] = $category;
        }

        if (!empty($_GET['search_for']) && !empty(!empty($_GET['search_data']))) {

            if ($_GET['search_for'] == 'product_name_one') {

                $where_arr['InProducts.product_name_one LIKE'] = "%" . $_GET['search_data'] . "%";
            }

            if ($_GET['search_for'] == 'product_name_two') {

                $where_arr['InProducts.product_name_two LIKE'] = "%" . $_GET['search_data'] . "%";
            }

            if ($_GET['search_for'] == 'style_no') {

                $where_arr['InProducts.style_number LIKE'] = "%" . $_GET['search_data'] . "%";
            }

            if ($_GET['search_for'] == 'prod_id') {

                $where_arr['InProducts.prod_id LIKE'] = "%" . $_GET['search_data'] . "%";
            }
        }





//        if ($this->request->session()->read('Auth.User.type') == 1) {


        $this->InProducts->belongsTo('InUsers', ['className' => 'InUsers', 'foreignKey' => 'brand_id']);

        /* $menproductdetails */$menproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['InProducts.profile_type' => '1', 'InProducts.brand_id !=' => 0, 'InProducts.is_merchandise' => 0])->contain(['InUsers'])->group('InProducts.prod_id');

        /* $womenproductdetails */$womenproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['InProducts.profile_type' => '2', 'InProducts.brand_id !=' => 0, 'InProducts.is_merchandise' => 0])->contain(['InUsers'])->group('InProducts.prod_id');

        /* $boyskidsproductdetails */$boyskidsproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['InProducts.profile_type' => '3', 'InProducts.brand_id !=' => 0, 'InProducts.is_merchandise' => 0])->contain(['InUsers'])->group('InProducts.prod_id');

        /* $girlkidsproductdetails */$girlkidsproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['InProducts.profile_type' => '4', 'InProducts.brand_id !=' => 0, 'InProducts.is_merchandise' => 0])->contain(['InUsers'])->group('InProducts.prod_id');

        if (!empty($where_arr)) {

            /* $menproductdetails */$menproductdetails1 = $menproductdetails1->where($where_arr);

            /* $womenproductdetails */$womenproductdetails1 = $womenproductdetails1->where($where_arr);

            /* $boyskidsproductdetails */$boyskidsproductdetails1 = $boyskidsproductdetails1->where($where_arr);

            /* $girlkidsproductdetails */$girlkidsproductdetails1 = $girlkidsproductdetails1->where($where_arr);
        }

        if (!empty($_GET['search_for']) && !empty(!empty($_GET['search_data']))) {

            if ($_GET['search_for'] == "brand_name") {
                $bnd_nm = trim($_GET['search_data']);
                $menproductdetails1 = $menproductdetails1->where(['InUsers.brand_name' => $bnd_nm]);
                $womenproductdetails1 = $womenproductdetails1->where(['InUsers.brand_name' => $bnd_nm]);
                $boyskidsproductdetails1 = $boyskidsproductdetails1->where(['InUsers.brand_name' => $bnd_nm]);
                $girlkidsproductdetails1 = $girlkidsproductdetails1->where(['InUsers.brand_name' => $bnd_nm]);
            }
        }

//        } else {
//
//            /* $menproductdetails */$menproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['profile_type' => '1', 'brand_id' => $this->request->session()->read('Auth.User.id')])->group('prod_id');
//
//            /* $womenproductdetails */$womenproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['profile_type' => '2', 'brand_id' => $this->request->session()->read('Auth.User.id')])->group('prod_id');
//
//            /* $boyskidsproductdetails */$boyskidsproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['profile_type' => '3', 'brand_id' => $this->request->session()->read('Auth.User.id')])->group('prod_id');
//
//            /* $girlkidsproductdetails */$girlkidsproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['profile_type' => '4', 'brand_id' => $this->request->session()->read('Auth.User.id')])->group('prod_id');
//            if (!empty($where_arr)) {
//                /* $menproductdetails */$menproductdetails1 = $menproductdetails1->where($where_arr);
//                /* $womenproductdetails */$womenproductdetails1 = $womenproductdetails1->where($where_arr);
//                /* $boyskidsproductdetails */$boyskidsproductdetails1 = $boyskidsproductdetails1->where($where_arr);
//                /* $girlkidsproductdetails */$girlkidsproductdetails1 = $girlkidsproductdetails1->where($where_arr);
//            }
//        }
//        $this->paginate['limit'] = 20;

        $productType = $this->InProductType->find('all')->order(['id' => 'ASC']);

        if (@$profile == 'Men' || @$profile == '') {

            $menproductdetails = $this->paginate($menproductdetails1);

            $productType = $productType->where(['user_type' => 1]);
        }

        if (@$profile == 'Women') {

            $womenproductdetails = $this->paginate($womenproductdetails1);
            $productType = $productType->where(['user_type' => 2]);
        }

        if (@$profile == 'BoyKids') {

            $boyskidsproductdetails = $this->paginate($boyskidsproductdetails1);
            $productType = $productType->where(['user_type' => 3]);
        }

        if (@$profile == 'GirlKids') {

            $girlkidsproductdetails = $this->paginate($girlkidsproductdetails1);
            $productType = $productType->where(['user_type' => 4]);
        }



//        $menproductdetails = $menproductdetails1;
//        $womenproductdetails = $womenproductdetails1;
//        $boyskidsproductdetails = $boyskidsproductdetails1;
//        $girlkidsproductdetails = $girlkidsproductdetails1;





        $brandsListings = $this->InUsers->find('all')->where(['type' => 3])->order(['id']);

        $this->set(compact('menproductdetails', 'womenproductdetails', 'boyskidsproductdetails', 'girlkidsproductdetails', 'profile', 'category', 'utype', 'brandsListings', 'productType'));
    }

    public function merchantProductList($profile = null, $category = null) {

        $utype = $this->request->session()->read('Auth.User.type');

        $where_arr = [];

        if (!empty($category)) {

            $where_arr['product_type'] = $category;
        }

        if (!empty($_GET['search_for']) && !empty(!empty($_GET['search_data']))) {

            if ($_GET['search_for'] == 'product_name_one') {

                $where_arr['InProducts.product_name_one LIKE'] = "%" . $_GET['search_data'] . "%";
            }

            if ($_GET['search_for'] == 'product_name_two') {

                $where_arr['InProducts.product_name_two LIKE'] = "%" . $_GET['search_data'] . "%";
            }

            if ($_GET['search_for'] == 'style_no') {

                $where_arr['InProducts.style_number LIKE'] = "%" . $_GET['search_data'] . "%";
            }

            if ($_GET['search_for'] == 'prod_id') {

                $where_arr['InProducts.prod_id LIKE'] = "%" . $_GET['search_data'] . "%";
            }
        }





//        if ($this->request->session()->read('Auth.User.type') == 1) {


        $this->InProducts->belongsTo('InUsers', ['className' => 'InUsers', 'foreignKey' => 'brand_id']);

        /* $menproductdetails */$menproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['InProducts.profile_type' => '1', 'InProducts.brand_id !=' => 0, 'InProducts.is_merchandise' => 1])->contain(['InUsers'])->group('InProducts.prod_id');

        /* $womenproductdetails */$womenproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['InProducts.profile_type' => '2', 'InProducts.brand_id !=' => 0, 'InProducts.is_merchandise' => 1])->contain(['InUsers'])->group('InProducts.prod_id');

        /* $boyskidsproductdetails */$boyskidsproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['InProducts.profile_type' => '3', 'InProducts.brand_id !=' => 0, 'InProducts.is_merchandise' => 1])->contain(['InUsers'])->group('InProducts.prod_id');

        /* $girlkidsproductdetails */$girlkidsproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['InProducts.profile_type' => '4', 'InProducts.brand_id !=' => 0, 'InProducts.is_merchandise' => 1])->contain(['InUsers'])->group('InProducts.prod_id');

        if (!empty($where_arr)) {

            /* $menproductdetails */$menproductdetails1 = $menproductdetails1->where($where_arr);

            /* $womenproductdetails */$womenproductdetails1 = $womenproductdetails1->where($where_arr);

            /* $boyskidsproductdetails */$boyskidsproductdetails1 = $boyskidsproductdetails1->where($where_arr);

            /* $girlkidsproductdetails */$girlkidsproductdetails1 = $girlkidsproductdetails1->where($where_arr);
        }

        if (!empty($_GET['search_for']) && !empty(!empty($_GET['search_data']))) {

            if ($_GET['search_for'] == "brand_name") {
                $bnd_nm = trim($_GET['search_data']);
                $menproductdetails1 = $menproductdetails1->where(['InUsers.brand_name' => $bnd_nm]);
                $womenproductdetails1 = $womenproductdetails1->where(['InUsers.brand_name' => $bnd_nm]);
                $boyskidsproductdetails1 = $boyskidsproductdetails1->where(['InUsers.brand_name' => $bnd_nm]);
                $girlkidsproductdetails1 = $girlkidsproductdetails1->where(['InUsers.brand_name' => $bnd_nm]);
            }
        }

//        } else {
//
//            /* $menproductdetails */$menproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['profile_type' => '1', 'brand_id' => $this->request->session()->read('Auth.User.id')])->group('prod_id');
//
//            /* $womenproductdetails */$womenproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['profile_type' => '2', 'brand_id' => $this->request->session()->read('Auth.User.id')])->group('prod_id');
//
//            /* $boyskidsproductdetails */$boyskidsproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['profile_type' => '3', 'brand_id' => $this->request->session()->read('Auth.User.id')])->group('prod_id');
//
//            /* $girlkidsproductdetails */$girlkidsproductdetails1 = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['profile_type' => '4', 'brand_id' => $this->request->session()->read('Auth.User.id')])->group('prod_id');
//            if (!empty($where_arr)) {
//                /* $menproductdetails */$menproductdetails1 = $menproductdetails1->where($where_arr);
//                /* $womenproductdetails */$womenproductdetails1 = $womenproductdetails1->where($where_arr);
//                /* $boyskidsproductdetails */$boyskidsproductdetails1 = $boyskidsproductdetails1->where($where_arr);
//                /* $girlkidsproductdetails */$girlkidsproductdetails1 = $girlkidsproductdetails1->where($where_arr);
//            }
//        }
//        $this->paginate['limit'] = 20;

        $productType = $this->InProductType->find('all')->order(['id' => 'ASC']);

        if (@$profile == 'Men' || @$profile == '') {

            $menproductdetails = $this->paginate($menproductdetails1);

            $productType = $productType->where(['user_type' => 1]);
        }

        if (@$profile == 'Women') {

            $womenproductdetails = $this->paginate($womenproductdetails1);
            $productType = $productType->where(['user_type' => 2]);
        }

        if (@$profile == 'BoyKids') {

            $boyskidsproductdetails = $this->paginate($boyskidsproductdetails1);
            $productType = $productType->where(['user_type' => 3]);
        }

        if (@$profile == 'GirlKids') {

            $girlkidsproductdetails = $this->paginate($girlkidsproductdetails1);
            $productType = $productType->where(['user_type' => 4]);
        }



//        $menproductdetails = $menproductdetails1;
//        $womenproductdetails = $womenproductdetails1;
//        $boyskidsproductdetails = $boyskidsproductdetails1;
//        $girlkidsproductdetails = $girlkidsproductdetails1;





        $brandsListings = $this->InUsers->find('all')->where(['type' => 3])->order(['id']);

        $this->set(compact('menproductdetails', 'womenproductdetails', 'boyskidsproductdetails', 'girlkidsproductdetails', 'profile', 'category', 'utype', 'brandsListings', 'productType'));
    }

    public function addProduct($profile = null, $id = null) {



        $editproduct = [];

        $in_rack = [];

        $user_type_arr = ['Men' => '1', 'Women' => '2', 'BoyKids' => '3', 'GirlKids' => '4'];

        if (empty($profile)) {
            $profile = "Men";
        }

        $product_ctg_nme = '';
        $product_sub_ctg_nme = '';

        if (!empty($id)) {

            $editproduct = $this->InProducts->find('all')->where(['id' => $id])->first();

            $productType_name_get = $this->InProductType->find('all')->where(['user_type' => $editproduct->profile_type])->where(['id' => $editproduct->product_type])->first();
            $product_ctg_nme = $productType_name_get->product_type;
            $in_rack = $this->InRack->find('all')->where(['in_product_type_id' => $editproduct->product_type])->order(['sort_order' => 'ASC']);

            if (!empty($editproduct->product_type) && !empty($editproduct->rack)) {

                $in_rack_name_get = $this->InRack->find('all')->where(['in_product_type_id' => $editproduct->product_type])->where(['id' => $editproduct->rack])->first();
                $product_sub_ctg_nme = $in_rack_name_get->rack_number;
            }
        }



        $utype = $this->request->session()->read('Auth.User.type');

        if ($this->request->is('post')) {
            $data = $this->request->data;

            foreach ($data as $d_ix => $d_dd) {

                if (empty($data[$d_ix])) {

                    if ((@$data['jeans'] == 0) || (@$data['jeans'] == 00) || (@$data['pants'] == 0) || (@$data['pants'] == 00)) {
                        
                    } else {

                        unset($data[$d_ix]);
                    }
                }
            }

            //  echo "<pre>";
            //         print_r($data);
            //         echo "</pre>";
            //         exit;

            $avatarName = "";

            if (!empty($data['product_image']['tmp_name'])) {

                if ($data['product_image']['size'] <= 20000) {



                    $avatarName = $this->Custom->uploadAvatarImage($data['product_image']['tmp_name'], $data['product_image']['name'], PRODUCT_IMAGES, 500);
                } else {

                    $this->Flash->error(__('Image size should be 8  to 20 kb'));

//                    exit;
                }
            } else {

                $dataEdit = $this->InProducts->find('all')->where(['id' => $data['id']])->first();

                $avatarName = $dataEdit->product_image;
            }



            if (!empty($data['profession'])) {

                $data['profession'] = json_encode($data['profession']);
            }

            if (!empty($data['season'])) {

                $data['season'] = json_encode($data['season']);
            }

            if (!empty($data['work_type'])) {

                $data['work_type'] = json_encode($data['work_type']);
            }

            if (!empty($data['style_sphere_selections_v5'])) {

                $data['style_sphere_selections_v5'] = json_encode($data['style_sphere_selections_v5']);
            }

            if (!empty($data['skin_tone'])) {

                $data['skin_tone'] = json_encode($data['skin_tone']);
            }

            if (!empty($data['take_note_of'])) {

                $data['take_note_of'] = json_encode($data['take_note_of']);
            }

            if (!empty($data['occasional_dress'])) {

                $data['occasional_dress'] = json_encode($data['occasional_dress']);
            }

            if (!empty($data['better_body_shape'])) {

                $data['better_body_shape'] = json_encode($data['better_body_shape']);
            }

            if (!empty($data['wo_top_half'])) {

                $data['wo_top_half'] = json_encode($data['wo_top_half']);
            }

            if (!empty($data['wo_style_insp'])) {

                $data['wo_style_insp'] = json_encode($data['wo_style_insp']);
            }

            if (!empty($data['denim_styles'])) {

                $data['denim_styles'] = json_encode($data['denim_styles']);
            }

            if (!empty($data['style_sphere_selections_v3'])) {

                $data['style_sphere_selections_v3'] = json_encode($data['style_sphere_selections_v3']);
            }

            if (!empty($data['outfit_prefer'])) {

                $data['outfit_prefer'] = json_encode($data['outfit_prefer']);
            }

            if (empty($data['primary_size'])) {
                $this->Flash->error(__('Size not selected'));
                return $this->redirect($this->referer());
            }


            $up_data_id = '';
            if ($data['id']) {
                $up_data_id = $data['id'];
//                echo "<pre>";
//                print_r($data);
//                echo "</pre>";
//                exit;

                $dataEdit = $this->InProducts->find('all')->where(['id' => $data['id']])->first();

                if (!empty($data['profile_type']) && ($data['profile_type'] == '1')) {



                    $profile = "MEN";

                    $nw_profile = "M";
                } else if (!empty($data['profile_type']) && ($data['profile_type'] == 2)) {



                    $profile = "WOM";

                    $nw_profile = "W";
                } else if (!empty($data['profile_type']) && ($data['profile_type'] == 3)) {



                    $profile = "BOY";

                    $nw_profile = "B";
                } else if (!empty($data['profile_type']) && ($data['profile_type'] == 4)) {



                    $profile = "GIRL";

                    $nw_profile = "G";
                }



                if (@$data['primary_size'] == 'shirt_size') {

                    $size = $data['shirt_size'];
                } else if (@$data['primary_size'] == 'shoe_size') {

                    $size = $data['shoe_size'];
                } else if (@$data['primary_size'] == 'waist_size') {

                    $size = $data['waist_size'];
                } else if (@$data['primary_size'] == 'wshoe_size') {

                    $size = $data['shoe_size'];
                } else if (@$data['primary_size'] == 'dress_size') {

                    $size = $data['dress'];
                } else if (@$data['primary_size'] == 'skirt_size') {

                    $size = $data['skirt'];
                } else if (@$data['primary_size'] == 'bra_size') {

                    $size = $data['bra'];
                } else if (@$data['primary_size'] == 'paint_size') {

                    $size = $data['pants'];
                } else if (@$data['primary_size'] == 'top_size') {

                    $size = $data['pantsr1'];
                } else if (@$data['primary_size'] == 'blouse_size') {

                    $size = $data['shirt_blouse'];
                } else if (@$data['primary_size'] == 'blouse_size') {

                    $size = $data['shirt_blouse'];
                } else if (@$data['primary_size'] == 'jeans') {

                    $size = $data['jeans'];
                } else if (@$data['primary_size'] == 'active_wr') {

                    $size = $data['active_wr'];
                } else if (@$data['primary_size'] == 'wo_jackect_size') {

                    $size = $data['wo_jackect_size'];
                } else if (@$data['primary_size'] == 'wo_bottom') {

                    $size = $data['wo_bottom'];
                } else if (@$data['primary_size'] == 'men_bottom') {

                    $size = $data['men_bottom'];
                } else if (@$data['primary_size'] == 'free_size') {

                    $size = 'F';
                }



                $picked_size = '';

                if (!empty($data['primary_size'])) {

                    if ($data['primary_size'] == "waist_size") {

                        $picked_size = "waist_size-waist_size_run";

                        if (!empty($data['profile_type']) && ($data['profile_type'] == '1')) {

                            $picked_size = "waist_size-waist_size_run-inseam_size";
                        }
                    }

                    if ($data['primary_size'] == "shirt_size") {

                        $picked_size = "shirt_size";
                    }

                    if ($data['primary_size'] == "shoe_size") {

                        $picked_size = "shoe_size";
                    }

                    if ($data['primary_size'] == "paint_size") {

                        $picked_size = "pants";
                    }

                    if ($data['primary_size'] == "bra_size") {

                        $picked_size = "bra-bra_recomend";
                    }

                    if ($data['primary_size'] == "skirt_size") {

                        $picked_size = "skirt";
                    }

                    if ($data['primary_size'] == "dress_size") {

                        $picked_size = "dress-dress_recomended";
                    }

                    if ($data['primary_size'] == "blouse_size") {

                        $picked_size = "shirt_blouse-shirt_blouse_recomend";
                    }

                    if ($data['primary_size'] == "top_size") {

                        $picked_size = "pantsr1-pantsr2";
                    }

                    if ($data['primary_size'] == "wshoe_size") {

                        $picked_size = "shoe_size-womenHeelHightPrefer";
                    }

                    if ($data['primary_size'] == "jeans") {

                        $picked_size = "jeans";
                    }

                    if ($data['primary_size'] == "active_wr") {

                        $picked_size = "active_wr";
                    }

                    if ($data['primary_size'] == "wo_jackect_size") {

                        $picked_size = "wo_jackect_size";
                    }

                    if ($data['primary_size'] == "wo_bottom") {

                        $picked_size = "wo_bottom";
                    }

                    if ($data['primary_size'] == "men_bottom") {

                        $picked_size = "men_bottom";
                    }

                    if (in_array($profile, ["BOY", "GIRL"])) {

                        if ($data['primary_size'] == "top_size") {

                            $picked_size = "top_size";

                            $size = $data['top_size'];
                        }

                        if ($data['primary_size'] == "bottom_size") {

                            $picked_size = "bottom_size";

                            $size = $data['bottom_size'];
                        }

                        if ($data['primary_size'] == "shoe_size") {

                            $picked_size = "shoe_size";

                            $size = $data['shoe_size'];
                        }
                    }
                }

                $data['picked_size'] = $picked_size;

                if (!empty($data['budget_type'])) {

                    $data['budget_value'] = $data[$data['budget_type']];
                }

                unset($data['wo_top_budg']);

                unset($data['wo_bottoms_budg']);

                unset($data['wo_outerwear_budg']);

                unset($data['wo_jeans_budg']);

                unset($data['wo_jewelry_budg']);

                unset($data['wo_accessories_budg']);

                unset($data['wo_dress_budg']);

                unset($data['id']);

                unset($data['product_image']);

                unset($data['men_shirt_budg']);

                unset($data['men_polos_budg']);

                unset($data['men_sweater_budg']);

                unset($data['men_pants_budg']);

                unset($data['men_shorts_budg']);

                unset($data['men_shoe_budg']);

                unset($data['men_outerwear_budg']);

                unset($data['men_ties_budg']);

                unset($data['men_belts_budg']);

                unset($data['men_bags_budg']);

                unset($data['men_sunglass_budg']);

                unset($data['men_hats_budg']);

                unset($data['men_socks_budg']);

                unset($data['men_underwear_budg']);

                unset($data['men_grooming_budg']);

                $this->InProducts->updateAll($data, ['prod_id' => $dataEdit->prod_id]);

                $this->InProducts->updateAll(['product_image' => $avatarName], ['prod_id' => $dataEdit->prod_id]);

                $last_update_products = $this->InProducts->find('all')->where(['prod_id' => $dataEdit->prod_id]);

                foreach ($last_update_products as $prod_liiii) {

                    $this->InProducts->updateAll([/* 'is_active' => 0, 'available_status' => 2, */'updated_by' => $this->request->session()->read('Auth.User.id'), 'updated_date' => date('Y-m-d H:i:s'), 'action' => 'edit'], ['id' => $prod_liiii->id]);

                    $newDtArr = [];

                    $newDtArr['product_id'] = $prod_liiii->id;

                    $newDtArr['user_id'] = $this->request->session()->read('Auth.User.id');

                    $newDtArr['action'] = 'edit';

                    $newDtArr['created_on'] = date('Y-m-d H:i:s');

                    $newDtArr['status'] = 2;

                    $newDtRow = $this->InProductLogs->newEntity();

                    $newDtRow = $this->InProductLogs->patchEntity($newDtRow, $newDtArr);

                    $this->InProductLogs->save($newDtRow);
                }

                //
//                echo "<pre>";
//                print_r($dataEdit);
//                print_r($data);
//                echo "</pre>";
//                exit;
            } else {

                $my_rnd = rand(111, 999) . time();
                if ($data['quantity'] < 1) {
                    $this->Flash->error(__('Quantity must be 1 or greater.'));
                    return $this->redirect($this->referer());
                }
                for ($ix = 1; $ix <= $data['quantity']; $ix++) {

                    $product = $this->InProducts->newEntity();

                    $product->id = '';

                    $product->user_id = $this->request->session()->read('Auth.User.id');

                    if (!empty($data['budget_type'])) {

                        $data['budget_value'] = $data[$data['budget_type']];
                    }

                    unset($data['wo_top_budg']);

                    unset($data['wo_bottoms_budg']);

                    unset($data['wo_outerwear_budg']);

                    unset($data['wo_jeans_budg']);

                    unset($data['wo_jewelry_budg']);

                    unset($data['wo_accessories_budg']);

                    unset($data['wo_dress_budg']);

                    unset($data['men_shirt_budg']);

                    unset($data['men_polos_budg']);

                    unset($data['men_sweater_budg']);

                    unset($data['men_pants_budg']);

                    unset($data['men_shorts_budg']);

                    unset($data['men_shoe_budg']);

                    unset($data['men_outerwear_budg']);

                    unset($data['men_ties_budg']);

                    unset($data['men_belts_budg']);

                    unset($data['men_bags_budg']);

                    unset($data['men_sunglass_budg']);

                    unset($data['men_hats_budg']);

                    unset($data['men_socks_budg']);

                    unset($data['men_underwear_budg']);

                    unset($data['men_grooming_budg']);

                    $product = $this->InProducts->patchEntity($product, $data);

                    $product->quantity = 1;

                    $product->is_active = 1;

                    $product->product_image = $avatarName;

                    $product->created = date("Y-m-d H:i:s");

                    if (!empty($data['profile_type']) && ($data['profile_type'] == '1')) {



                        $profile = "MEN";

                        $nw_profile = "M";
                    } else if (!empty($data['profile_type']) && ($data['profile_type'] == 2)) {



                        $profile = "WOM";

                        $nw_profile = "W";
                    } else if (!empty($data['profile_type']) && ($data['profile_type'] == 3)) {



                        $profile = "BOY";

                        $nw_profile = "B";
                    } else if (!empty($data['profile_type']) && ($data['profile_type'] == 4)) {



                        $profile = "GIRL";

                        $nw_profile = "G";
                    }





                    if (@$data['primary_size'] == 'shirt_size') {

                        $size = $data['shirt_size'];
                    } else if (@$data['primary_size'] == 'shoe_size') {

                        $size = $data['shoe_size'];
                    } else if (@$data['primary_size'] == 'waist_size') {

                        $size = $data['waist_size'];
                    } else if (@$data['primary_size'] == 'wshoe_size') {

                        $size = $data['shoe_size'];
                    } else if (@$data['primary_size'] == 'dress_size') {

                        $size = $data['dress'];
                    } else if (@$data['primary_size'] == 'skirt_size') {

                        $size = $data['skirt'];
                    } else if (@$data['primary_size'] == 'bra_size') {

                        $size = $data['bra'];
                    } else if (@$data['primary_size'] == 'paint_size') {

                        $size = $data['pants'];
                    } else if (@$data['primary_size'] == 'top_size') {

                        $size = $data['pantsr1'];
                    } else if (@$data['primary_size'] == 'blouse_size') {

                        $size = $data['shirt_blouse'];
                    } else if (@$data['primary_size'] == 'blouse_size') {

                        $size = $data['shirt_blouse'];
                    } else if (@$data['primary_size'] == 'jeans') {

                        $size = $data['jeans'];
                    } else if (@$data['primary_size'] == 'active_wr') {

                        $size = $data['active_wr'];
                    } else if (@$data['primary_size'] == 'wo_jackect_size') {

                        $size = $data['wo_jackect_size'];
                    } else if (@$data['primary_size'] == 'wo_bottom') {

                        $size = $data['wo_bottom'];
                    } else if (@$data['primary_size'] == 'men_bottom') {

                        $size = $data['men_bottom'];
                    } else if (@$data['primary_size'] == 'free_size') {

                        $size = 'F';
                    }



                    $picked_size = '';

                    if (!empty($data['primary_size'])) {

                        if ($data['primary_size'] == "waist_size") {

                            $picked_size = "waist_size-waist_size_run";

                            if (!empty($data['profile_type']) && ($data['profile_type'] == '1')) {

                                $picked_size = "waist_size-waist_size_run-inseam_size";
                            }
                        }

                        if ($data['primary_size'] == "shirt_size") {

                            $picked_size = "shirt_size-shirt_size_run";
                        }

                        if ($data['primary_size'] == "shoe_size") {

                            $picked_size = "shoe_size-shoe_size_run";
                        }

                        if ($data['primary_size'] == "paint_size") {

                            $picked_size = "pants";
                        }

                        if ($data['primary_size'] == "bra_size") {

                            $picked_size = "bra-bra_recomend";
                        }

                        if ($data['primary_size'] == "skirt_size") {

                            $picked_size = "skirt";
                        }

                        if ($data['primary_size'] == "dress_size") {

                            $picked_size = "dress-dress_recomended";
                        }

                        if ($data['primary_size'] == "blouse_size") {

                            $picked_size = "shirt_blouse-shirt_blouse_recomend";
                        }

                        if ($data['primary_size'] == "top_size") {

                            $picked_size = "pantsr1-pantsr2";
                        }

                        if ($data['primary_size'] == "wshoe_size") {

                            $picked_size = "shoe_size-womenHeelHightPrefer-shoe_size_run";
                        }

                        if ($data['primary_size'] == "jeans") {

                            $picked_size = "jeans";
                        }

                        if ($data['primary_size'] == "active_wr") {

                            $picked_size = "active_wr";
                        }

                        if ($data['primary_size'] == "wo_jackect_size") {

                            $picked_size = "wo_jackect_size";
                        }

                        if ($data['primary_size'] == "wo_bottom") {

                            $picked_size = "wo_bottom";
                        }

                        if ($data['primary_size'] == "men_bottom") {

                            $picked_size = "men_bottom";
                        }





                        if (in_array($profile, ["BOY", "GIRL"])) {

                            if ($data['primary_size'] == "top_size") {

                                $picked_size = "top_size";

                                $size = $data['top_size'];
                            }

                            if ($data['primary_size'] == "bottom_size") {

                                $picked_size = "bottom_size";

                                $size = $data['bottom_size'];
                            }

                            if ($data['primary_size'] == "shoe_size") {

                                $picked_size = "shoe_size";

                                $size = $data['shoe_size'];
                            }
                        }

//                 var_dump([in_array($profile, ["BOY", "GIRL"]),$picked_size]);exit;
                    }

                    $product->picked_size = $picked_size;

                    $brand = @$data['brand_id'];

                    $rack = @$data['rack'];

                    $ptype = @$data['product_type'];

                    $qty = @$data['quantity'];

//            @$dtls = $this->Custom->dtls($profile, $brand, @$rack, $ptype, $size, $qty);

                    @$dtls = $this->Custom->dtls($nw_profile, $brand, @$rack, $ptype, $size, $qty);

                    $product->dtls = $dtls;

                    $product->rack = $rack;

                    $product->p_type = $ptype;

                    if ($this->InProducts->save($product)) {



//                        echo "<pre>";
//                        echo $dtls;
//                        print_r($product);
//                        echo "</pre>";



                        $last_id = $product->id;

//                        $this->InProducts->updateAll(['is_active' => 0, 'available_status' => 2], ['id' => $last_id]);
//                        $this->InProducts->updateAll(['is_active' => 0, 'available_status' => 2, 'updated_by'=>$this->request->session()->read('Auth.User.id'),'updated_date'=>date('Y-m-d H:i:s'), 'action'=>'add'], ['id' => $last_id]);

                        $this->InProducts->updateAll(['action' => 'add'], ['id' => $last_id]);

                        $newDtArr = [];

                        $newDtArr['product_id'] = $last_id;

                        $newDtArr['user_id'] = $this->request->session()->read('Auth.User.id');

                        $newDtArr['action'] = 'add';

                        $newDtArr['status'] = 2;

                        $newDtArr['created_on'] = date('Y-m-d H:i:s');

                        $newDtRow = $this->InProductLogs->newEntity();

                        $newDtRow = $this->InProductLogs->patchEntity($newDtRow, $newDtArr);

                        $this->InProductLogs->save($newDtRow);

//                        echo "<pre>";
//                        echo $last_id;
//                        print_r($product);
//                        echo "</pre>";
//                        exit;



                        if (empty($last_id)) {

                            $last_id = $this->InProducts->find('all')->order(['id' => 'DESC'])->first()->id;
                        }

                        $prd_id = $dtls . "-" . $my_rnd;

                        $style_number = $dtls . '-' . $last_id . '-' . $ix;

                        $dtls = $last_id /* . '-' . $ix */;

//                        echo "<pre>";
//                        echo "<br>-" . $last_id;
//                        echo "<br>--" . $prd_id;
//                        echo "<br>---" . $dtls;
//                        echo "</pre>";
                        //Need to add code for update time no need to create

                        if (!empty($dtls)) {

                            $name = $dtls . '.png';

                            $barcode_value = $dtls;

                            $this->Custom->create_image($name);

                            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                            $dataImg = "data:image/png;base64," . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128));

                            list($type, $dataImg) = explode(';', $dataImg);

                            list(, $dataImg) = explode(',', $dataImg);

                            $dataImg = base64_decode($dataImg);

                            file_put_contents(BARCODE . $name, $dataImg);

                            $this->InProducts->updateAll(['bar_code_img' => $name], ['id' => $last_id]);
                        }



                        $this->InProducts->updateAll(['dtls' => $dtls, 'prod_id' => $prd_id, 'style_number' => $style_number], ['id' => $last_id]);

                        //echo $profile; exit;
                        //pj($product); exit;
                    }
                }
            }



            /* echo "<pre>";

              print_r($newDtArr); */

            $missingFields = "";

            $all_product_ids = $newDtArr['product_id'];

            if (!empty($all_product_ids)) {

                $this->InProducts->belongsTo('rak', ['className' => 'InRack', 'foreignKey' => 'rack']);

                $this->InProducts->belongsTo('ctg', ['className' => 'InProductType', 'foreignKey' => 'product_type']);

                $this->InProducts->hasMany('emp_log', ['className' => 'InProductLogs', 'foreignKey' => 'product_id'])->setConditions(['emp_log.user_id' => $_GET['employee']]);

                $prd_li = $this->InProducts->find('all')->where(['InProducts.id' => $all_product_ids])->contain(['emp_log', 'ctg', 'rak'])->first();

                $profile_type = $prd_li->profile_type;

                $product_prod_id = $prd_li->prod_id;

                if ($profile_type == 1) {

                    $chk_fld_empty = [
                        'profile_type' => 'Gender/Profile Type',
                        'product_type' => 'Product Category',
                        'rack' => 'Product Sub-Category',
                        'product_name_one' => 'Product Name1',
//                        'product_name_two' => 'Product Name2',
                        'season' => 'Season',
                        'tall_feet' => 'Height Range',
                        'tall_feet2' => 'Height Range',
                        'best_fit_for_weight' => 'Weight Range',
                        'best_fit_for_weight2' => 'Weight Range',
                        'age1' => 'Age',
                        'age2' => 'Age',
//                        'profession' => 'Profession',
//                        'best_size_fit' => 'Best Size fit',
                        'better_body_shape' => 'Body Shape',
                        'skin_tone' => 'Skin Tone',
                        'skin_tone' => 'Skin Tone',
                        'work_type' => 'Typically wear to work?',
//                        'style_sphere_selections_v5' => 'Prefer to wear',
                        'take_note_of' => 'Any Fit issue',
                        'purchase_price' => 'Purchase Price',
                        'sale_price' => 'Sale Price',
                        'quantity' => 'Quantity',
                        'brand_id' => 'Brand Name',
                        'product_image' => 'Image',
                        'color' => 'Product Color'
                    ];

                    $prd_empty_fld = [];

                    foreach ($chk_fld_empty as $cfe_ky => $cfe_li) {

                        $flddd = $prd_li->$cfe_ky;

                        if (empty($flddd) || in_array($flddd, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = $cfe_li;
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["B1"])) {

                        if (empty($prd_li->casual_shirts_type) || in_array($prd_li->casual_shirts_type, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Casual Shirts to fit';
                        }

                        if (empty($prd_li->shirt_size) || in_array($prd_li->shirt_size, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Shirts Size';
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["B2", "B11"])) {

                        if (empty($prd_li->casual_shirts_type) || in_array($prd_li->casual_shirts_type, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Casual Shirts to fit';
                        }

                        if (empty($prd_li->shirt_size) || in_array($prd_li->shirt_size, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Shirts Size';
                        }

                        if (empty($prd_li->bottom_up_shirt_fit) || in_array($prd_li->bottom_up_shirt_fit, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Button up shirt to fit';
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["B3", "B4"])) {

                        if ((empty($prd_li->waist_size) || in_array($prd_li->waist_size, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Waist size';
                        }

                        if ((empty($prd_li->inseam_size) || in_array($prd_li->inseam_size, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Inseam size';
                        }

                        if ((empty($prd_li->men_bottom) || in_array($prd_li->men_bottom, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Bottom Size';
                        }

                        if (empty($prd_li->shirt_size) || in_array($prd_li->shirt_size, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Bottom Fit';
                        }

                        if (empty($prd_li->bottom_up_shirt_fit) || in_array($prd_li->bottom_up_shirt_fit, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Jeans to fit';
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["B5"])) {

                        if ((empty($prd_li->waist_size) || in_array($prd_li->waist_size, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Waist size';
                        }

                        if ((empty($prd_li->inseam_size) || in_array($prd_li->inseam_size, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Inseam size';
                        }

                        if ((empty($prd_li->men_bottom) || in_array($prd_li->men_bottom, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Bottom Size';
                        }

                        if (empty($prd_li->shirt_size) || in_array($prd_li->shirt_size, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Bottom Fit';
                        }

                        if (empty($prd_li->bottom_up_shirt_fit) || in_array($prd_li->bottom_up_shirt_fit, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Jeans to fit';
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["B6"])) {

                        if ((empty($prd_li->waist_size) || in_array($prd_li->waist_size, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Waist size';
                        }

                        if ((empty($prd_li->men_bottom) || in_array($prd_li->men_bottom, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Bottom Size';
                        }

                        if (empty($prd_li->shorts_long) || in_array($prd_li->shorts_long, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Shorts long';
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["B7"])) {

                        if (empty($prd_li->casual_shirts_type) || in_array($prd_li->casual_shirts_type, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Casual Shirts to fit';
                        }

                        if (empty($prd_li->shirt_size) || in_array($prd_li->shirt_size, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Shirts Size';
                        }

                        if ((empty($prd_li->men_bottom) || in_array($prd_li->men_bottom, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Bottom Size';
                        }

                        if (empty($prd_li->shorts_long) || in_array($prd_li->shorts_long, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Shorts long';
                        }

                        if (empty($prd_li->men_bottom_prefer) || in_array($prd_li->men_bottom_prefer, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Bottom Fit';
                        }

                        if (empty($prd_li->jeans_Fit) || in_array($prd_li->jeans_Fit, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Jeans Fit';
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["B14"])) {

                        if (!empty($prd_li->primary_size) && ($prd_li->primary_size == "free_size")) {

                            $prd_empty_fld[] = 'FREE SIZE';
                        }
                    }

                    $missingFields = implode(',&nbsp;&nbsp;', array_unique($prd_empty_fld));
                }

                if ($profile_type == 2) {

                    $chk_fld_empty = [
                        'profile_type' => 'Gender/Profile Type',
                        'product_type' => 'Product Category',
                        'rack' => 'Product Sub-Category',
                        'product_name_one' => 'Product Name1',
//                        'product_name_two' => 'Product Name2',
                        'season' => 'Season',
                        'tall_feet' => 'Height Range',
                        'tall_feet2' => 'Height Range',
                        'best_fit_for_weight' => 'Weight Range',
                        'best_fit_for_weight2' => 'Weight Range',
                        'age1' => 'Age',
                        'age2' => 'Age',
//                        'profession' => 'Profession',
//                        'occasional_dress' => 'Occasions',
                        'better_body_shape' => 'Body Shape',
                        'purchase_price' => 'Purchase Price',
                        'sale_price' => 'Sale Price',
                        'quantity' => 'Quantity',
                        'brand_id' => 'Brand Name',
                        'product_image' => 'Image',
                        'color' => 'Product Color',
//                        'style_sphere_selections_v3' => 'Outfit to wear',
                        'skin_tone' => 'Skin Tone',
                        'available_status' => 'Available status',
                    ];

                    $prd_empty_fld = [];

                    foreach ($chk_fld_empty as $cfe_ky => $cfe_li) {

                        $flddd = $prd_li->$cfe_ky;

                        if (empty($flddd) || in_array($flddd, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = $cfe_li;
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["A1"])) {

                        if (empty($prd_li->shirt_blouse) || in_array($prd_li->shirt_blouse, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'SHIRT & BLOUSE';
                        }

                        if (empty($prd_li->wo_style_insp) || in_array($prd_li->wo_style_insp, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Style Inspiration';
                        }

                        if (empty($prd_li->wo_top_half) || in_array($prd_li->wo_top_half, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top half';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

                        if (empty($prd_li->wo_top_style) || in_array($prd_li->wo_top_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top type';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }
//                        if (empty($prd_li->proportion_shoulders) || in_array($prd_li->proportion_shoulders, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Shoulders?';
//                        }

                        if (empty($prd_li->proportion_arms) || in_array($prd_li->proportion_arms, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Arms?';
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["A2"])) {

                        if (empty($prd_li->dress) || in_array($prd_li->dress, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Dress';
                        }

                        if (empty($prd_li->wo_style_insp) || in_array($prd_li->wo_style_insp, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Style Inspiration';
                        }

                        if (empty($prd_li->wo_dress_length) || in_array($prd_li->wo_dress_length, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Dress length';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }
//                        if (empty($prd_li->proportion_shoulders) || in_array($prd_li->proportion_shoulders, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Shoulders?';
//                        }

                        if (empty($prd_li->proportion_arms) || in_array($prd_li->proportion_arms, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Arms?';
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["A3"])) {

                        if (empty($prd_li->dress) || in_array($prd_li->dress, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Dress';
                        }

                        if (empty($prd_li->wo_style_insp) || in_array($prd_li->wo_style_insp, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Style Inspiration';
                        }

                        if (empty($prd_li->wo_top_half) || in_array($prd_li->wo_top_half, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top half';
                        }

                        if (empty($prd_li->wo_top_style) || in_array($prd_li->wo_top_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top type';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }
//                        if (empty($prd_li->proportion_shoulders) || in_array($prd_li->proportion_shoulders, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Shoulders?';
//                        }

                        if (empty($prd_li->proportion_arms) || in_array($prd_li->proportion_arms, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Arms?';
                        }

                        if (empty($prd_li->proportion_legs) || in_array($prd_li->proportion_legs, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Legs?';
                        }

//                        if (empty($prd_li->proportion_hips) || in_array($prd_li->proportion_hips, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Hips ?';
//                        }

                        if (empty($prd_li->wo_pant_length) || in_array($prd_li->wo_pant_length, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant Length';
                        }

                        if (empty($prd_li->wo_pant_style) || in_array($prd_li->wo_pant_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant style';
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["A4"]) && in_array($prd_li->rak->rack_number, ["A41", "A42", "A47"])) {

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }

                        if (empty($prd_li->proportion_legs) || in_array($prd_li->proportion_legs, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Legs?';
                        }

//                        if (empty($prd_li->proportion_hips) || in_array($prd_li->proportion_hips, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Hips ?';
//                        }

                        if (empty($prd_li->wo_pant_length) || in_array($prd_li->wo_pant_length, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant Length';
                        }

                        if (empty($prd_li->wo_pant_rise) || in_array($prd_li->wo_pant_rise, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant Rise';
                        }

                        if (empty($prd_li->wo_pant_style) || in_array($prd_li->wo_pant_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant style';
                        }

                        if (empty($prd_li->pants) || in_array($prd_li->pants, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pants';
                        }

                        if (empty($prd_li->wo_bottom) || in_array($prd_li->wo_bottom, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'BOTTOM SIZE';
                        }

                        if (empty($prd_li->wo_bottom_style) || in_array($prd_li->wo_bottom_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Bottoms type';
                        }
                    }



                    if (in_array($prd_li->ctg->product_type, ["A4"]) && in_array($prd_li->rak->rack_number, ["A43", "A45"])) {

                        if (empty($prd_li->wo_top_half) || in_array($prd_li->wo_top_half, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top half';
                        }

                        if (empty($prd_li->wo_top_style) || in_array($prd_li->wo_top_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top type';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }

                        if (empty($prd_li->wo_style_insp) || in_array($prd_li->wo_style_insp, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Style Inspiration';
                        }

//                        if (empty($prd_li->proportion_shoulders) || in_array($prd_li->proportion_shoulders, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Shoulders?';
//                        }

                        if (empty($prd_li->proportion_arms) || in_array($prd_li->proportion_arms, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Arms?';
                        }

                        if (empty($prd_li->shirt_blouse) || in_array($prd_li->shirt_blouse, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'SHIRT & BLOUSE';
                        }

                        if (empty($prd_li->active_wr) || in_array($prd_li->active_wr, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'ACTIVE WEAR SIZE';
                        }
                    }



                    if (in_array($prd_li->ctg->product_type, ["A4"]) && in_array($prd_li->rak->rack_number, ["A44"])) {

                        if (empty($prd_li->wo_top_half) || in_array($prd_li->wo_top_half, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top half';
                        }

                        if (empty($prd_li->wo_top_style) || in_array($prd_li->wo_top_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top type';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }

                        if (empty($prd_li->wo_style_insp) || in_array($prd_li->wo_style_insp, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Style Inspiration';
                        }

                        if (empty($prd_li->shirt_blouse) || in_array($prd_li->shirt_blouse, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'SHIRT & BLOUSE';
                        }

                        if (empty($prd_li->active_wr) || in_array($prd_li->active_wr, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'ACTIVE WEAR SIZE';
                        }

                        if (empty($prd_li->bra) || in_array($prd_li->bra, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'BRA';
                        }
                    }



                    if (in_array($prd_li->ctg->product_type, ["A4"]) && in_array($prd_li->rak->rack_number, ["A46"])) {

                        if (empty($prd_li->shirt_blouse) || in_array($prd_li->shirt_blouse, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'SHIRT & BLOUSE';
                        }

                        if (empty($prd_li->active_wr) || in_array($prd_li->active_wr, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'ACTIVE WEAR SIZE';
                        }

                        if (empty($prd_li->pants) || in_array($prd_li->pants, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pants';
                        }

                        if (empty($prd_li->bra) || in_array($prd_li->bra, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'BRA SIZE';
                        }

                        if (empty($prd_li->wo_bottom) || in_array($prd_li->wo_bottom, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'BOTTOM SIZE';
                        }

                        if (empty($prd_li->wo_jackect_size) || in_array($prd_li->wo_jackect_size, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'JACKET SIZE';
                        }
                    }





                    if (in_array($prd_li->ctg->product_type, ["A5"])) {

                        if (empty($prd_li->jeans) || in_array($prd_li->jeans, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'JEANS SIZE';
                        }

                        if (empty($prd_li->wo_bottom) || in_array($prd_li->wo_bottom, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'BOTTOM SIZE';
                        }

                        if (empty($prd_li->wo_style_insp) || in_array($prd_li->wo_style_insp, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Style Inspiration';
                        }

                        if (empty($prd_li->wo_pant_rise) || in_array($prd_li->wo_pant_rise, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant Rise';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

                        if (empty($prd_li->wo_bottom_style) || in_array($prd_li->wo_bottom_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Bottoms type';
                        }

                        if (empty($prd_li->proportion_legs) || in_array($prd_li->proportion_legs, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Legs?';
                        }

//                        if (empty($prd_li->proportion_hips) || in_array($prd_li->proportion_hips, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Hips ?';
//                        }
                    }



                    if (in_array($prd_li->ctg->product_type, ["A6"])) {

                        if (empty($prd_li->skirt) || in_array($prd_li->skirt, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'SKIRT SIZE';
                        }

                        if (empty($prd_li->wo_style_insp) || in_array($prd_li->wo_style_insp, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Style Inspiration';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

                        if (empty($prd_li->wo_bottom_style) || in_array($prd_li->wo_bottom_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Bottoms type';
                        }

                        if (empty($prd_li->wo_dress_length) || in_array($prd_li->wo_dress_length, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Dress length';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }

                        if (empty($prd_li->proportion_legs) || in_array($prd_li->proportion_legs, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Legs?';
                        }

//                        if (empty($prd_li->proportion_hips) || in_array($prd_li->proportion_hips, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Hips ?';
//                        }
                    }



                    if (in_array($prd_li->ctg->product_type, ["A7"])) {

                        if (empty($prd_li->jeans) || in_array($prd_li->jeans, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'JEANS SIZE';
                        }

                        if ((empty($prd_li->wo_bottom) || in_array($prd_li->wo_bottom, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Bottom Size';
                        }

                        if (empty($prd_li->wo_pant_length) || in_array($prd_li->wo_pant_length, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant Length';
                        }

                        if (empty($prd_li->wo_pant_rise) || in_array($prd_li->wo_pant_rise, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant Rise';
                        }

                        if (empty($prd_li->wo_pant_style) || in_array($prd_li->wo_pant_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant style';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

                        if (empty($prd_li->wo_bottom_style) || in_array($prd_li->wo_bottom_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Bottoms type';
                        }

                        if (empty($prd_li->denim_styles) || in_array($prd_li->denim_styles, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Denim styles?';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }

                        if (empty($prd_li->proportion_legs) || in_array($prd_li->proportion_legs, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Legs?';
                        }

//                        if (empty($prd_li->proportion_hips) || in_array($prd_li->proportion_hips, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Hips ?';
//                        }
                    }



                    if (in_array($prd_li->ctg->product_type, ["A8"])) {

                        if (empty($prd_li->jeans) || in_array($prd_li->jeans, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'JEANS SIZE';
                        }

                        if ((empty($prd_li->wo_bottom) || in_array($prd_li->wo_bottom, ['NULL', 'null', '']))) {

                            $prd_empty_fld[] = 'Bottom Size';
                        }

                        if (empty($prd_li->wo_pant_length) || in_array($prd_li->wo_pant_length, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant Length';
                        }

                        if (empty($prd_li->wo_pant_rise) || in_array($prd_li->wo_pant_rise, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant Rise';
                        }

                        if (empty($prd_li->wo_pant_style) || in_array($prd_li->wo_pant_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Pant style';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

                        if (empty($prd_li->wo_bottom_style) || in_array($prd_li->wo_bottom_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Bottoms type';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }

                        if (empty($prd_li->proportion_legs) || in_array($prd_li->proportion_legs, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Legs?';
                        }

//                        if (empty($prd_li->proportion_hips) || in_array($prd_li->proportion_hips, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Hips ?';
//                        }
                    }



                    if (in_array($prd_li->ctg->product_type, ["A9", "A10", "A11", "A12"])) {

                        if (empty($prd_li->shirt_blouse) || in_array($prd_li->shirt_blouse, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'SHIRT & BLOUSE';
                        }

                        if (empty($prd_li->wo_style_insp) || in_array($prd_li->wo_style_insp, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Style Inspiration';
                        }

//                        if ((empty($prd_li->men_bottom) || in_array($prd_li->men_bottom, ['NULL', 'null', '']))) {
//                            $prd_empty_fld[] = 'Bottom Size';
//                        }

                        if (empty($prd_li->wo_top_half) || in_array($prd_li->wo_top_half, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top half';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

                        if (empty($prd_li->wo_top_style) || in_array($prd_li->wo_top_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top type';
                        }

//                        if (empty($prd_li->missing_from_your_fIT) || in_array($prd_li->missing_from_your_fIT, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Missing from fit/your closet?';
//                        }
//                        if (empty($prd_li->wo_dress_length) || in_array($prd_li->wo_dress_length, ['NULL', 'null', ''])) {
//
//                            $prd_empty_fld[] = 'Dress length';
//                        }
//                        if (empty($prd_li->proportion_shoulders) || in_array($prd_li->proportion_shoulders, ['NULL', 'null', ''])) {
//                            $prd_empty_fld[] = 'Shoulders?';
//                        }

                        if (empty($prd_li->proportion_arms) || in_array($prd_li->proportion_arms, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Arms?';
                        }
                    }



                    if (in_array($prd_li->ctg->product_type, ["A14"]) && in_array($prd_li->rak->rack_number, ["A141", "A142", "A143", "A144", "A145", "A146", "A147", "A148", "A149", "A1410", "A1412"])) {



                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

                        if (!empty($prd_li->primary_size) && ($prd_li->primary_size == "free_size")) {

                            $prd_empty_fld[] = 'FREE SIZE';
                        }
                    }



                    if (in_array($prd_li->ctg->product_type, ["A14"]) && in_array($prd_li->rak->rack_number, ["A1411"])) {

                        if (empty($prd_li->shirt_blouse) || in_array($prd_li->shirt_blouse, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'SHIRT & BLOUSE';
                        }

                        if (empty($prd_li->wo_top_half) || in_array($prd_li->wo_top_half, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top half';
                        }

                        if (empty($prd_li->wo_appare) || in_array($prd_li->wo_appare, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Appare type';
                        }

                        if (empty($prd_li->wo_top_style) || in_array($prd_li->wo_top_style, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = 'Top type';
                        }
                    }

                    $missingFields = implode(', ', array_unique($prd_empty_fld));
                }

                if ($profile_type == 3) {
                    $chk_fld_empty = [
                        'profile_type' => 'Gender/Profile Type',
                        'product_type' => 'Product Category',
                        'rack' => 'Product Sub-Category',
                        'product_name_one' => 'Product Name1',
                        'season' => 'Season',
                        'tall_feet' => 'Height Range',
                        'tall_feet2' => 'Height Range',
                        'best_fit_for_weight' => 'Weight Range',
                        'best_fit_for_weight2' => 'Weight Range',
                        'age1' => 'Age',
                        'age2' => 'Age',
                        'kid_body_shape' => 'Body Shape',
                        'brand_id' => 'Brand Name',
                        'product_image' => 'Image',
                        'color' => 'Product Color',
                        'purchase_price' => 'Purchase Price',
                        'sale_price' => 'Sale Price',
                        'quantity' => 'Quantity',
                        'available_status' => 'Available status',
                    ];

                    $prd_empty_fld = [];

                    foreach ($chk_fld_empty as $cfe_ky => $cfe_li) {

                        $flddd = $prd_li->$cfe_ky;

                        if (empty($flddd) || in_array($flddd, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = $cfe_li;
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["C1", "C2", "C4", "C6", "C8"])) {
                        if (empty($prd_li->top_size) || in_array($prd_li->top_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Top Size';
                        }
                    }
                    if (in_array($prd_li->ctg->product_type, ["C3", "C5"])) {
                        if (empty($prd_li->bottom_size) || in_array($prd_li->bottom_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Bottom Size';
                        }
                    }
                    if (in_array($prd_li->ctg->product_type, ["C9"])) {
                        if ((empty($prd_li->top_size) && empty($prd_li->bottom_size)) || in_array($prd_li->bottom_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Bottom Size';
                        }
                        if ((empty($prd_li->top_size) && empty($prd_li->bottom_size)) || in_array($prd_li->top_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Top Size';
                        }
                    }
                    if (in_array($prd_li->ctg->product_type, ["C12"])) {
                        if (empty($prd_li->primary_size) || in_array($prd_li->primary_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Free Size';
                        }
                        if (!empty($prd_li->primary_size) && ($prd_li->primary_size != "free_size")) {
                            $prd_empty_fld[] = 'Free Size';
                        }
                    }
                    $missingFields = implode(',&nbsp;&nbsp;', array_unique($prd_empty_fld));
                }

                if ($profile_type == 4) {
                    $chk_fld_empty = [
                        'profile_type' => 'Gender/Profile Type',
                        'product_type' => 'Product Category',
                        'rack' => 'Product Sub-Category',
                        'product_name_one' => 'Product Name1',
                        'season' => 'Season',
                        'tall_feet' => 'Height Range',
                        'tall_feet2' => 'Height Range',
                        'best_fit_for_weight' => 'Weight Range',
                        'best_fit_for_weight2' => 'Weight Range',
                        'age1' => 'Age',
                        'age2' => 'Age',
                        'kid_body_shape' => 'Body Shape',
                        'brand_id' => 'Brand Name',
                        'product_image' => 'Image',
                        'color' => 'Product Color',
                        'purchase_price' => 'Purchase Price',
                        'sale_price' => 'Sale Price',
                        'quantity' => 'Quantity',
                        'available_status' => 'Available status',
                    ];

                    $prd_empty_fld = [];

                    foreach ($chk_fld_empty as $cfe_ky => $cfe_li) {

                        $flddd = $prd_li->$cfe_ky;

                        if (empty($flddd) || in_array($flddd, ['NULL', 'null', ''])) {

                            $prd_empty_fld[] = $cfe_li;
                        }
                    }

                    if (in_array($prd_li->ctg->product_type, ["D1", "D2", "D3", "D7", "D8", "D9"])) {
                        if (empty($prd_li->top_size) || in_array($prd_li->top_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Top Size';
                        }
                    }
                    if (in_array($prd_li->ctg->product_type, ["D4", "D5", "D6"])) {
                        if (empty($prd_li->bottom_size) || in_array($prd_li->bottom_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Bottom Size';
                        }
                    }
                    if (in_array($prd_li->ctg->product_type, ["D11"])) {
                        if (empty($prd_li->bottom_size) || in_array($prd_li->bottom_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Bottom Size';
                        }
                        if (empty($prd_li->top_size) || in_array($prd_li->top_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Top Size';
                        }
                    }
                    if (in_array($prd_li->ctg->product_type, ["D12"])) {
                        if (empty($prd_li->primary_size) || in_array($prd_li->primary_size, ['NULL', 'null', ''])) {
                            $prd_empty_fld[] = 'Free Size';
                        }
                        if (!empty($prd_li->primary_size) && ($prd_li->primary_size != "free_size")) {
                            $prd_empty_fld[] = 'Free Size';
                        }
                    }
                    $missingFields = implode(',&nbsp;&nbsp;', array_unique($prd_empty_fld));
                }
            }

            /* exit; */

            /* if (!empty($missingFields)) {

              $this->request->session()->write('missing_fields', $missingFields);

              $this->Flash->success(__("Missing fields : " . $missingFields));
              } else { */



            if (!empty($up_data_id)) {

                $this->Flash->success(__('Data Updated successfully.'));
            } else {
                $this->InProducts->updateAll(['is_active' => 1, 'available_status' => 1], ['prod_id' => $product_prod_id]);

                $this->Flash->success(__('Data Inserted successfully.'));
                if ($profile == 'MEN' || $profile == '') {
                    return $this->redirect(HTTP_ROOT . 'appadmins/add_product/Men/');
                }
                if ($profile == 'WOM') {
                    return $this->redirect(HTTP_ROOT . 'appadmins/add_product/Women/');
                }
                if ($profile == 'BOY') {
                    return $this->redirect(HTTP_ROOT . 'appadmins/add_product/BoyKids/');
                }
                if ($profile == 'GIRL') {
                    return $this->redirect(HTTP_ROOT . 'appadmins/add_product/GirlKids/');
                }
            }
            /* } */

            if ($profile == 'MEN' || $profile == '') {
                return $this->redirect(HTTP_ROOT . 'appadmins/add_product/Men/' . $all_product_ids);
            }if ($profile == 'WOM') {
                return $this->redirect(HTTP_ROOT . 'appadmins/add_product/Women/' . $all_product_ids);
            }if ($profile == 'BOY') {
                return $this->redirect(HTTP_ROOT . 'appadmins/add_product/BoyKids/' . $all_product_ids);
            }if ($profile == 'GIRL') {
                return $this->redirect(HTTP_ROOT . 'appadmins/add_product/GirlKids/' . $all_product_ids);
            }
        }


        $brandsListings = $this->InUsers->find('all')->where(['type' => 3])->order(['id']);

        $productType = $this->InProductType->find('all')->where(['user_type' => $user_type_arr[$profile]])->order(['sort_order' => 'ASC']);

        if (!empty($_GET['ctg'])) {
            $productType_name_get = $this->InProductType->find('all')->where(['user_type' => $user_type_arr[$profile]])->where(['id' => $_GET['ctg']])->first();
            $product_ctg_nme = $productType_name_get->product_type;
            $in_rack = $this->InRack->find('all')->where(['in_product_type_id' => $_GET['ctg']])->order(['sort_order' => 'ASC']);
        }
        if (!empty($_GET['ctg']) && !empty($_GET['sub_ctg'])) {

            $in_rack_name_get = $this->InRack->find('all')->where(['in_product_type_id' => $_GET['ctg']])->where(['id' => $_GET['sub_ctg']])->first();
            $product_sub_ctg_nme = $in_rack_name_get->rack_number;
        }

        $this->set(compact('utype', 'in_rack', 'productType', 'id', 'editproduct', 'profile', 'brandsListings', 'product_ctg_nme', 'product_sub_ctg_nme'));
    }

    function brandName($id = null) {



        if (@$id) {



            $brand_name = $this->InUsers->find('all')->contain(['InProducts'])->where(['InProducts.user_id' => $this->Auth->InUsers('id')])->first();

            return($brand_name);
        }
    }

    public function viewProduct() {



        $productdetails = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC']);

        $this->set(compact('productdetails'));
    }

    public function productimgdelete($profile = null, $id = null) {



        $this->viewBuilder()->layout('admin');

        if ($id) {



            $list = $this->InProducts->find('all', ['Fields' => ['product_image']])->where(['id' => $id])->first();

            unlink(PRODUCT_IMAGES . '/' . $list->product_image);

            $this->InProducts->updateAll(array('product_image' => NULL), array(['prod_id' => $list->prod_id]));

            if ($profile == 'Men' || $profile == '') {



                $this->Flash->success(__('Image Deleted successfully.'));

                $this->redirect(HTTP_ROOT . 'appadmins/add_product/Men/' . $id);
            }if ($profile == 'Women') {



                $this->Flash->success(__('Image Deleted successfully.'));

                $this->redirect(HTTP_ROOT . 'appadmins/add_product/Women/' . $id);
            }if ($profile == 'BoyKids') {



                $this->Flash->success(__('Image Deleted successfully.'));

                $this->redirect(HTTP_ROOT . 'appadmins/add_product/BoyKids/' . $id);
            }if ($profile == 'GirlKids') {



                $this->Flash->success(__('Image Deleted successfully.'));

                $this->redirect(HTTP_ROOT . 'appadmins/add_product/GirlKids/' . $id);
            }
        }
    }

    public function createStaff($id = null) {







        if ($id) {



            $editAdmin = $this->InUsers->find('all')->where(['InUsers.id' => $id])->first();
        }



        if ($this->request->is('post')) {

            $data = $this->request->data;

            $exitEmail = $this->InUsers->find('all')->where(['InUsers.email' => @$data['email']])->count();

            $password = @$data['password'];

            $conpassword = @$data['cpassword'];

            if ($exitEmail >= 1) {



                $this->Flash->success(__('This  Email is already exists.'));

                return $this->redirect(HTTP_ROOT . 'appadmins/create_staff/');
            }



            if ($password != $conpassword) {



                $this->Flash->success(__("Password and confirm password are not same"));

                return $this->redirect(HTTP_ROOT . 'appadmins/create_staff/');
            }



            $admin = $this->InUsers->newEntity();

            // $hasher = new DefaultPasswordHasher();
            // $pwd = $hasher->hash($password);



            $data['unique_id'] = $this->Custom->generateUniqNumber();

            $data['password'] = (new DefaultPasswordHasher)->hash($data['password']);

            $data['created_dt'] = date("Y-m-d H:i:s");

            $data['modified'] = date("Y-m-d H:i:s");

            $data['is_active'] = 1;

            $data['type'] = 3;

            $admin = $this->InUsers->patchEntity($admin, $data);

            if (@$id) {



                $admin->id = $id;
            } else {



                $admin->id = '';
            }



            //print_r($data);
            // print_r($admin); exit;



            if ($this->InUsers->save($admin)) {







                if ($id) {



                    $this->Flash->success(__('Data updated successfully.'));

                    // return $this->redirect(HTTP_ROOT . 'appadmins/create_staff/' . $id);



                    return $this->redirect(HTTP_ROOT . 'appadmins/view_staff/');
                } else {



                    /*

                      $emailMessage = $this->Settings->find('all')->where(['Settings.name' => 'CREATE_ADMIN'])->first();

                      $fromMail = $this->Settings->find('all')->where(['Settings.name' => 'FROM_EMAIL'])->first();

                      $to = $admin->email;

                      $from = $fromMail->value;

                      $subject = $emailMessage->display;

                      $sitename = SITE_NAME;

                      $password = $password;



                      //echo "hello";

                      //echo $password;exit;



                      $message = $this->Custom->createAdminFormat($emailMessage->value, $admin->name, $admin->email, $password, $sitename);

                      $kid_id = 0;

                      $this->Custom->sendEmail($to, $from, $subject, $message, $kid_id);



                      $toSupport = $this->Settings->find('all')->where(['name' => 'TO_HELP'])->first()->value;



                      $this->Custom->sendEmail($toSupport, $from, $subject, $message, $kid_id);

                     */



                    $this->Flash->success(__('Data add successfully.'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/view_staff');
                }
            }
        }



        $this->set(compact('admin', 'id', 'editAdmin'));
    }

    public function viewStaff() {



        $adminLists = $this->InUsers->find('all', ['InUsers.id' => 'DESC'])->where(['InUsers.type' => 3]);

        $this->set(compact('adminLists'));
    }

    public function setPassword($id = null) {



        $passwordData = $this->InUsers->newEntity();

        $setPassword = $this->InUsers->find('all')->where(['InUsers.id' => $id])->first();

        if ($this->request->is('post')) {



            $data = $this->request->data;

            $password = $data['password'];

            $conpassword = $data['cpassword'];

            if ($password != $conpassword) {



                $this->Flash->error(__("Password and confirm password are not same"));
            } else {



                $data['password'] = (new DefaultPasswordHasher)->hash($data['password']);

                $passwordData = $this->InUsers->patchEntity($passwordData, $data);

                $passwordData->id = $data['id'];

                if ($this->InUsers->save($passwordData)) {



                    $emailMessage = $this->Settings->find('all')->where(['Settings.name' => 'CREATE_ADMIN'])->first();

                    $fromMail = $this->Settings->find('all')->where(['Settings.name' => 'FROM_EMAIL'])->first();

                    $to = $setPassword->email;

                    $from = $fromMail->value;

                    $subject = $emailMessage->display;

                    $sitename = SITE_NAME;

                    $message = $this->Custom->createAdminFormat($emailMessage->value, $setPassword->name, $to, $password, $sitename);

                    $kid_id = 0;

                    $this->Custom->sendEmail($to, $from, $subject, $message, $kid_id);

                    $toSupport = $this->Settings->find('all')->where(['name' => 'TO_HELP'])->first()->value;

                    $this->Custom->sendEmail($toSupport, $from, $subject, $message, $kid_id);

                    $this->Flash->success(__('Password set successfully.'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/view_staff');
                }
            }
        }



        $this->set(compact('passwordData', 'setPassword'));
    }

    public function deactive($id = null, $table = null) {



        $active_column = 'is_active';

        if ($this->$table->query()->update()->set([$active_column => 0])->where(['id' => $id])->execute()) {



            if ($table == 'InProducts') {



//                $this->$table->query()->update()->set(['is_active' => 0, 'available_status' => 2])->where(['id' => $id])->execute();

                $list = $this->InProducts->find('all')->where(['id' => $id])->first();

                $this->$table->updateAll(['is_active' => 0, 'available_status' => 2], ['prod_id' => $list->prod_id]);

                $last_update_products = $this->InProducts->find('all')->where(['prod_id' => $list->prod_id]);

                foreach ($last_update_products as $prod_liiii) {

                    $newDtArr = [];

                    $newDtArr['product_id'] = $prod_liiii->id;

                    $newDtArr['user_id'] = $this->request->session()->read('Auth.User.id');

                    $newDtArr['action'] = 'deactive';

                    $newDtArr['created_on'] = date('Y-m-d H:i:s');

                    $newDtRow = $this->InProductLogs->newEntity();

                    $newDtRow = $this->InProductLogs->patchEntity($newDtRow, $newDtArr);

                    $this->InProductLogs->save($newDtRow);
                }





                $this->Flash->success(__('Product is deactivated.'));

                $this->redirect($this->referer());
            } else if ($table == 'InUsers') {



                $this->$table->query()->update()->set(['is_active' => 0])->where(['id' => $id])->execute();

                $this->Flash->success(__('User has been deactivated.'));

                $this->redirect($this->referer());
            }
        }
    }

    public function active($id = null, $table = null) {



        $active_column = 'is_active';

        if ($this->$table->query()->update()->set([$active_column => 1])->where(['id' => $id])->execute()) {



            if ($table == 'InProducts') {



//                $this->$table->query()->update()->set(['is_active' => 1, 'available_status' => 1])->where(['id' => $id])->execute();

                $list = $this->InProducts->find('all')->where(['id' => $id])->first();

                $this->$table->updateAll(['is_active' => 1, 'available_status' => 1], ['prod_id' => $list->prod_id]);

                $last_update_products = $this->InProducts->find('all')->where(['prod_id' => $list->prod_id]);

                foreach ($last_update_products as $prod_liiii) {

                    $newDtArr = [];

                    $newDtArr['product_id'] = $prod_liiii->id;

                    $newDtArr['user_id'] = $this->request->session()->read('Auth.User.id');

                    $newDtArr['action'] = 'active';

                    $newDtArr['created_on'] = date('Y-m-d H:i:s');

                    $newDtRow = $this->InProductLogs->newEntity();

                    $newDtRow = $this->InProductLogs->patchEntity($newDtRow, $newDtArr);

                    $this->InProductLogs->save($newDtRow);
                }



                $this->Flash->success(__('Product is activated.'));

                $this->redirect($this->referer());
            } else if ($table == 'InUsers') {



                $this->$table->query()->update()->set(['is_active' => 1])->where(['id' => $id])->execute();

                $this->Flash->success(__('User has been activated.'));

                $this->redirect($this->referer());
            }
        }
    }

    public function editMailTempletes($id = null) {



        $this->viewBuilder()->layout('admin');

        $row = $this->Settings->find('all')->where(['Settings.id' => $id])->first();

        $dataEntity = $this->Settings->newEntity();

        if ($this->request->is('post')) {



            $data = $this->request->data;

            $dataEntity = $this->Settings->patchEntity($dataEntity, $data);

            $this->Settings->save($dataEntity);

            $this->Flash->success(__('Email templet has been update successfully.'));

            return $this->redirect(HTTP_ROOT . 'appadmins/profile/emailTemplete');
        }



        $this->set(compact('id', 'row'));
    }

    public function logout() {



        session_destroy();

        session_unset();

        foreach (@$_COOKIE as $key => $value) {



            unset($value);
        }



        $this->Flash->success('You are now logged out.');

        $this->viewBuilder()->layout('default');

        $type = $this->Auth->user('type');

        $this->request->session()->write('PROFILE', '');

        $this->request->session()->write('KID_ID', '');

        $this->request->session()->write('PROFILE', '');

        if ($this->Auth->logout()) {



            if ($type == 2) {



                return $this->redirect(HTTP_ROOT);
            } else if ($type == 1) {



                return $this->redirect(HTTP_ROOT . 'admin/');
            } else if ($type == 3) {



                return $this->redirect(HTTP_ROOT . 'admin/');
            }
        } else {



            return $this->redirect(HTTP_ROOT);
        }



        return $this->redirect(HTTP_ROOT);
    }

    public function rackSet($catg = null, $id = null) {

        $all_category = $this->InProductType->find('all');

        if (@$id) {

            $editData = $this->InRack->find('all')->where(['id' => $id])->first();

            @$getNumber = $editData->rack_number;
        } else {



            @$getNumber = $this->InRack->find('all')->order(['id' => 'DESC'])->first()->rack_number + 1;
        }



        if ($this->request->is('post')) {



            $data = $this->request->data;

            $ent = $this->InRack->newEntity();

            if (@$data['id']) {



                $checkData = $this->InRack->find('all')->where(['rack_name' => trim(strtoupper($data['rack_name'])), 'id !=' => $data['id']])->first();

                if (@$checkData->rack_name != '') {



                    $this->Flash->error(__('Name is already exit'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/rack_set/' . $data['id']);

                    //break;
                }



                $ent->id = $id;
            } else {



                $checkData = $this->InRack->find('all')->where(['rack_name' => trim(strtoupper($data['rack_name']))])->first();

                if (@$checkData->rack_name != '') {



                    $this->Flash->error(__('Name is already exit'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/rack_set');

                    //break;
                }







                $ent->id = '';

                $data['rack_name'] = strtoupper($data['rack_name']);

                $data['is_active'] = 1;
            }



            $ent = $this->InRack->patchEntity($ent, $data);

            if ($this->InRack->save($ent)) {



                if ($id) {



                    $this->Flash->success(__('Data Updated successfully.'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/rack_set/' . $catg . '/' . $id);
                } else {



                    $this->Flash->success(__('Data Inserted successfully.'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/rack_set');
                }
            }
        }



        $this->InRack->belongsTo('ipt', ['className' => 'InProductType', 'foreignKey' => 'in_product_type_id']);

        $datas = $this->InRack->find('all')->order(['InRack.id' => 'asc'])->contain(['ipt']);

        $this->set(compact('id', 'editData', 'getNumber', 'datas', 'all_category', 'catg'));
    }

    public function rackDelete($id = null) {



        $getDetail = $this->InRack->find('all')->where(['id' => $id])->first();

        $data = $this->InRack->get($id);

        $dataDelete = $this->InRack->delete($data);

        if ($dataDelete) {



            $this->Flash->success(__('Data has been deleted successfully.'));

            $this->redirect($this->referer());
        }
    }

    public function productType($id = null) {



        if (@$id) {



            $editData = $this->InProductType->find('all')->where(['id' => $id])->first();
        }



        if ($this->request->is('post')) {



            $data = $this->request->data;

            $ent = $this->InProductType->newEntity();

            if (@$data['id']) {



                $checkData = $this->InProductType->find('all')->where(['product_type' => trim(strtoupper($data['product_type'])), 'id !=' => $data['id']])->first();

                if (@$checkData->product_type != '') {



                    $this->Flash->error(__('Name is already exit'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/product_type/' . $data['id']);

                    //break;
                }



                $ent->id = $id;
            } else {



                $checkData = $this->InProductType->find('all')->where(['product_type' => trim(strtoupper($data['product_type']))])->first();

                if (@$checkData->product_type != '') {



                    $this->Flash->error(__('Name is already exit'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/product_type');

                    //break;
                }



                $ent->id = '';

                $data['product_type'] = strtoupper($data['product_type']);

                $data['is_active'] = 1;
            }



            $ent = $this->InProductType->patchEntity($ent, $data);

            if ($this->InProductType->save($ent)) {



                if ($id) {



                    $this->Flash->success(__('Data Updated successfully.'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/product_type/' . $id);
                } else {



                    $this->Flash->success(__('Data Inserted successfully.'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/product_type');
                }
            }
        }



        $datas = $this->InProductType->find('all')->order(['id' => 'asc']);

        $this->set(compact('id', 'editData', 'datas'));
    }

    public function productTypeDelete($id = null) {



        $getDetail = $this->InProductType->find('all')->where(['id' => $id])->first();

        $data = $this->InProductType->get($id);

        $dataDelete = $this->InProductType->delete($data);

        if ($dataDelete) {



            $this->Flash->success(__('Data has been deleted successfully.'));

            $this->redirect($this->referer());
        }
    }

    public function getSubCatgList() {

        $html = '<option value="" selected disabled>No data found</option>';

        if ($this->request->is('post')) {

            $data = $this->request->data;

            $allData = $this->InRack->find('all')->where(['in_product_type_id' => $data['id']]);

            if (!empty($allData->count())) {

                $html = '';

                foreach ($allData as $list) {

                    $html .= '<option value="' . $list->id . '">' . $list->rack_number . '-' . $list->rack_name . '</option>';
                }
            }
        }

        echo $html;

        exit;
    }

    public function listProduct($prod_id) {

        $all_products = $this->InProducts->find('all')->where(['prod_id' => $prod_id])->order(['id' => 'DESC']);
        if (!empty($_GET) && ($_GET['merchant'] == 1)) {
            $all_products = $all_products->where(['is_merchandise' => 1]);
        }
        $this->set(compact('all_products'));
    }

    public function barcodePrints($id = null) {

        $this->viewBuilder()->layout('');
        if (!empty($_GET) && ($_GET['merchant'] == 1)) {
            $product = $this->InProducts->find('all')->where(['id' => $id]);
            $product = $product->where(['is_merchandise' => 1]);
            $product = $product->first();

            $dtls = $product->id;
            if (!empty($dtls)) {

                $name = $dtls . '.png';

                $barcode_value = $dtls;

                $this->Custom->create_image($name);

                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                $dataImg = "data:image/png;base64," . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128));

                list($type, $dataImg) = explode(';', $dataImg);

                list(, $dataImg) = explode(',', $dataImg);

                $dataImg = base64_decode($dataImg);

                file_put_contents(BARCODE . $name, $dataImg);

                $this->InProducts->updateAll(['bar_code_img' => $name], ['id' => $product->id]);
            }
        }

        $product = $this->InProducts->find('all')->where(['id' => $id]);
        if (!empty($_GET) && ($_GET['merchant'] == 1)) {
            $product = $product->where(['is_merchandise' => 1]);
        }
        $product = $product->first();
        $this->set(compact('product'));
    }

    public function allBarcodePrints($prod_id = null) {

        $this->viewBuilder()->layout('');
if (!empty($_GET) && ($_GET['merchant'] == 1)) {
        $all_product = $this->InProducts->find('all')->where(['prod_id' => $prod_id]);
        
            $all_product = $all_product->where(['is_merchandise' => 1]);
        
        foreach ($all_product as $prd_li) {
            $dtls = $prd_li->id;
            if (!empty($dtls)) {

                $name = $dtls . '.png';

                $barcode_value = $dtls;

                $this->Custom->create_image($name);

                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                $dataImg = "data:image/png;base64," . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128));

                list($type, $dataImg) = explode(';', $dataImg);

                list(, $dataImg) = explode(',', $dataImg);

                $dataImg = base64_decode($dataImg);

                file_put_contents(BARCODE . $name, $dataImg);

                $this->InProducts->updateAll(['bar_code_img' => $name], ['id' => $prd_li->id]);
            }
        }
}
        $all_product = $this->InProducts->find('all')->where(['prod_id' => $prod_id]);
        if (!empty($_GET) && ($_GET['merchant'] == 1)) {
            $all_product = $all_product->where(['is_merchandise' => 1]);
        }

        $this->set(compact('all_product'));
    }

    public function inColor($id = null, $option = null) {

        $all_data = $this->InColors->find('all');

        $editData = [];

        if (!empty($id)) {

            $editData = $this->InColors->find('all')->where(['id' => $id])->first();
        }

        if (!empty($option) && ($option == "delete")) {

            $editData = $this->InColors->deleteAll(['id' => $id]);

            $this->Flash->success(__('Color has been deleted successfully.'));

            $this->redirect(HTTP_ROOT . 'appadmins/in_color');
        }

        if ($this->request->is('post')) {

            $data = $this->request->data;

            if (!empty($id)) {

                $data['id'] = $id;
            }



            $dataEntity = $this->InColors->newEntity();

            $dataEntity = $this->InColors->patchEntity($dataEntity, $data);

            $this->InColors->save($dataEntity);

            if (!empty($id)) {

                $this->Flash->success(__('Color has been updated successfully.'));

                $this->redirect(HTTP_ROOT . 'appadmins/in_color/' . $id . '/edit');
            } else {

                $this->Flash->success(__('Color has been added successfully.'));

                $this->redirect(HTTP_ROOT . 'appadmins/in_color');
            }
        }



        $this->set(compact('editData', 'all_data'));
    }

    public function manualReturnProductList() {

        $productList = [];

        if ($this->request->session()->read('Auth.User.type') == 1) {

            $productList = $this->InProducts->find('all')->order(['InProducts.id' => 'DESC'])->where(['brand_id' => 0]);
        }

        $this->set(compact('productList'));
    }

    public function addManualProductInList($id, $profile) {

        $productDetails = [];

        if ($this->request->session()->read('Auth.User.type') == 1) {

            $productDetails = $this->InProducts->find('all')->where(['brand_id' => 0, 'id' => $id])->first();
        }

        $brandsListings = $this->InUsers->find('all')->where(['type' => 3])->order(['id']);

        $productType = $this->InProductType->find('all')->order(['id' => 'ASC']);

        if ($this->request->is('post')) {



            $data = $this->request->data;

            $my_rnd = rand(111, 999) . time();

            $ix = 1;

            if (!empty($data['prod_id'])) {

                $chk_prod_data = $this->InProducts->find('all')->where(['prod_id' => $data['prod_id']])->count();

                if ($chk_prod_data < 1) {

                    $this->Flash->error(__('Invalid Existing Product sceret code.'));

                    return $this->redirect(HTTP_ROOT . 'appadmins/manual_return_product_list');
                }
            }



            $avatarName = "";

            if (!empty($data['product_image']['tmp_name'])) {

                if ($data['product_image']['size'] <= 20000) {



                    $avatarName = $this->Custom->uploadAvatarImage($data['product_image']['tmp_name'], $data['product_image']['name'], PRODUCT_IMAGES, 500);
                } else {

                    $this->Flash->error(__('Image size should be 8  to 20 kb'));
                }
            } else {

                $dataEdit = $this->InProducts->find('all')->where(['id' => $data['id']])->first();

                $avatarName = $dataEdit->product_image;
            }





            $product = $this->InProducts->newEntity();

            $product->id = $data['id'];

            $product->user_id = $this->request->session()->read('Auth.User.id');

            if (!empty($data['budget_type'])) {

                $data['budget_value'] = $data[$data['budget_type']];
            }

            unset($data['wo_top_budg']);

            unset($data['wo_bottoms_budg']);

            unset($data['wo_outerwear_budg']);

            unset($data['wo_jeans_budg']);

            unset($data['wo_jewelry_budg']);

            unset($data['wo_accessories_budg']);

            unset($data['wo_dress_budg']);

            unset($data['men_shirt_budg']);

            unset($data['men_polos_budg']);

            unset($data['men_sweater_budg']);

            unset($data['men_pants_budg']);

            unset($data['men_shorts_budg']);

            unset($data['men_shoe_budg']);

            unset($data['men_outerwear_budg']);

            unset($data['men_ties_budg']);

            unset($data['men_belts_budg']);

            unset($data['men_bags_budg']);

            unset($data['men_sunglass_budg']);

            unset($data['men_hats_budg']);

            unset($data['men_socks_budg']);

            unset($data['men_underwear_budg']);

            unset($data['men_grooming_budg']);

            $product = $this->InProducts->patchEntity($product, $data);

            $product->quantity = 1;

            $product->is_active = 1;

            $product->product_image = $avatarName;

            $product->created = date("Y-m-d H:i:s");

            if (!empty($data['profile_type']) && ($data['profile_type'] == '1')) {



                $profile = "MEN";

                $nw_profile = "M";
            } else if (!empty($data['profile_type']) && ($data['profile_type'] == 2)) {



                $profile = "WOM";

                $nw_profile = "W";
            } else if (!empty($data['profile_type']) && ($data['profile_type'] == 3)) {



                $profile = "BOY";

                $nw_profile = "B";
            } else if (!empty($data['profile_type']) && ($data['profile_type'] == 4)) {



                $profile = "GIRL";

                $nw_profile = "G";
            }





            if (@$data['primary_size'] == 'shirt_size') {

                $size = $data['shirt_size'];
            } else if (@$data['primary_size'] == 'shoe_size') {

                $size = $data['shoe_size'];
            } else if (@$data['primary_size'] == 'waist_size') {

                $size = $data['waist_size'];
            } else if (@$data['primary_size'] == 'wshoe_size') {

                $size = $data['shoe_size'];
            } else if (@$data['primary_size'] == 'dress_size') {

                $size = $data['dress'];
            } else if (@$data['primary_size'] == 'skirt_size') {

                $size = $data['skirt'];
            } else if (@$data['primary_size'] == 'bra_size') {

                $size = $data['bra'];
            } else if (@$data['primary_size'] == 'paint_size') {

                $size = $data['pants'];
            } else if (@$data['primary_size'] == 'top_size') {

                $size = $data['pantsr1'];
            } else if (@$data['primary_size'] == 'blouse_size') {

                $size = $data['shirt_blouse'];
            } else if (@$data['primary_size'] == 'blouse_size') {

                $size = $data['shirt_blouse'];
            } else if (@$data['primary_size'] == 'jeans') {

                $size = $data['jeans'];
            } else if (@$data['primary_size'] == 'active_wr') {

                $size = $data['active_wr'];
            } else if (@$data['primary_size'] == 'wo_jackect_size') {

                $size = $data['wo_jackect_size'];
            } else if (@$data['primary_size'] == 'wo_bottom') {

                $size = $data['wo_bottom'];
            } else if (@$data['primary_size'] == 'men_bottom') {

                $size = $data['men_bottom'];
            } else if (@$data['primary_size'] == 'free_size') {

                $size = 'F';
            }



            $picked_size = '';

            if (!empty($data['primary_size'])) {

                if ($data['primary_size'] == "waist_size") {

                    $picked_size = "waist_size-waist_size_run";

                    if (!empty($data['profile_type']) && ($data['profile_type'] == '1')) {

                        $picked_size = "waist_size-waist_size_run-inseam_size";
                    }
                }

                if ($data['primary_size'] == "shirt_size") {

                    $picked_size = "shirt_size-shirt_size_run";
                }

                if ($data['primary_size'] == "shoe_size") {

                    $picked_size = "shoe_size-shoe_size_run";
                }

                if ($data['primary_size'] == "paint_size") {

                    $picked_size = "pants";
                }

                if ($data['primary_size'] == "bra_size") {

                    $picked_size = "bra-bra_recomend";
                }

                if ($data['primary_size'] == "skirt_size") {

                    $picked_size = "skirt";
                }

                if ($data['primary_size'] == "dress_size") {

                    $picked_size = "dress-dress_recomended";
                }

                if ($data['primary_size'] == "blouse_size") {

                    $picked_size = "shirt_blouse-shirt_blouse_recomend";
                }

                if ($data['primary_size'] == "top_size") {

                    $picked_size = "pantsr1-pantsr2";
                }

                if ($data['primary_size'] == "wshoe_size") {

                    $picked_size = "shoe_size-womenHeelHightPrefer-shoe_size_run";
                }

                if ($data['primary_size'] == "jeans") {

                    $picked_size = "jeans";
                }

                if ($data['primary_size'] == "active_wr") {

                    $picked_size = "active_wr";
                }

                if ($data['primary_size'] == "wo_jackect_size") {

                    $picked_size = "wo_jackect_size";
                }

                if ($data['primary_size'] == "wo_bottom") {

                    $picked_size = "wo_bottom";
                }

                if ($data['primary_size'] == "men_bottom") {

                    $picked_size = "men_bottom";
                }





                if (in_array($profile, ["BOY", "GIRL"])) {

                    if ($data['primary_size'] == "top_size") {

                        $picked_size = "top_size";

                        $size = $data['top_size'];
                    }

                    if ($data['primary_size'] == "bottom_size") {

                        $picked_size = "bottom_size";

                        $size = $data['bottom_size'];
                    }

                    if ($data['primary_size'] == "shoe_size") {

                        $picked_size = "shoe_size";

                        $size = $data['shoe_size'];
                    }
                }

//                 var_dump([in_array($profile, ["BOY", "GIRL"]),$picked_size]);exit;
            }

            $product->picked_size = $picked_size;

            $brand = @$data['brand_id'];

            $rack = @$data['rack'];

            $ptype = @$data['product_type'];

            $qty = @$data['quantity'];

//            @$dtls = $this->Custom->dtls($profile, $brand, @$rack, $ptype, $size, $qty);

            @$dtls = $this->Custom->dtls($nw_profile, $brand, @$rack, $ptype, $size, $qty);

            $product->dtls = $dtls;

            $product->rack = $rack;

            $product->p_type = $ptype;

            if ($this->InProducts->save($product)) {

//                        echo "<pre>";
//                        echo $dtls;
//                        print_r($product);
//                        echo "</pre>";



                $last_id = $product->id;

                if (empty($last_id)) {

                    $last_id = $this->InProducts->find('all')->order(['id' => 'DESC'])->first()->id;
                }

                if (!empty($data['prod_id'])) {

                    $prd_id = $data['prod_id'];
                } else {

                    $prd_id = $dtls . "-" . $my_rnd;
                }

                $dtls = $dtls . '-' . $last_id . '-' . $ix;

//                        echo "<pre>";
//                        echo "<br>-" . $last_id;
//                        echo "<br>--" . $prd_id;
//                        echo "<br>---" . $dtls;
//                        echo "</pre>";
                //Need to add code for update time no need to create

                if (!empty($dtls)) {

                    $name = $dtls . '.png';

                    $barcode_value = $dtls;

                    $this->Custom->create_image($name);

                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                    $dataImg = "data:image/png;base64," . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128));

                    list($type, $dataImg) = explode(';', $dataImg);

                    list(, $dataImg) = explode(',', $dataImg);

                    $dataImg = base64_decode($dataImg);

                    file_put_contents(BARCODE . $name, $dataImg);

                    $this->InProducts->updateAll(['bar_code_img' => $name], ['id' => $last_id]);
                }



                $this->InProducts->updateAll(['dtls' => $dtls, 'prod_id' => $prd_id], ['id' => $last_id]);

                //echo $profile; exit;
                //pj($product); exit;
            }

            $this->Flash->success(__('Data added successfully.'));

            return $this->redirect(HTTP_ROOT . 'appadmins/manual_return_product_list');
        }





        $this->set(compact('productDetails', 'brandsListings', 'productType', 'id', 'profile'));
    }

    public function inventoryReport() {

        $this->loadModel('InUsers');

        $this->InUsers->hasMany('men', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['men.profile_type' => 1, 'men.match_status' => 2]);

        $this->InUsers->hasMany('women', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['women.profile_type' => 2, 'women.match_status' => 2]);

        $this->InUsers->hasMany('boy', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['boy.profile_type' => 3, 'boy.match_status' => 2]);

        $this->InUsers->hasMany('girl', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['girl.profile_type' => 4, 'girl.match_status' => 2]);

        $user_product_list = $this->InUsers->find('all')->contain(['men', 'women', 'boy', 'girl']);

        $this->set(compact('user_product_list'));
    }

    public function inventoryReportPdf() {



        $this->loadModel('InUsers');

        $this->InUsers->hasMany('men', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['men.profile_type' => 1, 'men.match_status' => 2]);

        $this->InUsers->hasMany('women', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['women.profile_type' => 2, 'women.match_status' => 2]);

        $this->InUsers->hasMany('boy', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['boy.profile_type' => 3, 'boy.match_status' => 2]);

        $this->InUsers->hasMany('girl', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['girl.profile_type' => 4, 'girl.match_status' => 2]);

        $user_product_list = $this->InUsers->find('all')->contain(['men', 'women', 'boy', 'girl']);

        $this->set(compact('user_product_list'));

        if (true) {

            // initializing mPDF



            $this->Mpdf->init();

            $this->Mpdf->AddPage('L');

            // setting filename of output pdf file

            $this->Mpdf->setFilename(REPORT_PDF . time() . rand(111, 999) . '.pdf');

            // setting output to I, D, F, S

            $this->Mpdf->setOutput('D');

            // you can call any mPDF method via component, for example:

            $this->Mpdf->SetWatermarkText("Draft");
        }
    }

    public function inventoryReportExcel($value = null) {

        $type = $this->request->session()->read('Auth.User.type');

        $id = $this->request->session()->read('Auth.User.id');

        /* if ($type == 1) { */

        $this->loadModel('InUsers');

        $this->InUsers->hasMany('men', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['men.profile_type' => 1, 'men.match_status' => 2]);

        $this->InUsers->hasMany('women', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['women.profile_type' => 2, 'women.match_status' => 2]);

        $this->InUsers->hasMany('boy', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['boy.profile_type' => 3, 'boy.match_status' => 2]);

        $this->InUsers->hasMany('girl', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['girl.profile_type' => 4, 'girl.match_status' => 2]);

        $user_product_list = $this->InUsers->find('all')->contain(['men', 'women', 'boy', 'girl']);

        /* } else {

          $this->Flash->error(__('You are not allowed to access.'));

          $this->redirect(HTTP_ROOT . 'appadmins/');

          } */





        $data_list = [];

        $count = 0;

        foreach ($user_product_list as $n_dt) {

            $data_list[$count]['name'] = $n_dt->brand_name;

            $tt_m_pc = 0;

            foreach ($n_dt->men as $mn_li) {

                $tt_m_pc += $mn_li->sale_price;
            }

            $data_list[$count]['men'] = count($n_dt->men);

            $data_list[$count]['men_total'] = number_format($tt_m_pc, 2, '.', '');

            $tt_w_pc = 0;

            foreach ($n_dt->women as $mn_li) {

                $tt_w_pc += $mn_li->sale_price;
            }

            $data_list[$count]['women'] = count($n_dt->women);

            $data_list[$count]['women_total'] = number_format($tt_w_pc, 2, '.', '');

            $tt_b_pc = 0;

            foreach ($n_dt->boy as $mn_li) {

                $tt_b_pc += $mn_li->sale_price;
            }

            $data_list[$count]['boy'] = count($n_dt->boy);

            $data_list[$count]['boy_total'] = number_format($tt_b_pc, 2, '.', '');

            $tt_g_pc = 0;

            foreach ($n_dt->girl as $mn_li) {

                $tt_g_pc += $mn_li->sale_price;
            }

            $data_list[$count]['girl'] = count($n_dt->girl);

            $data_list[$count]['girl_total'] = number_format($tt_g_pc, 2, '.', '');

            $count++;
        }



        $fileName = strtotime(date('Y-m-d H:i:s'));

        $file_name = $this->Custom->inventoryReportExcel($data_list, $fileName);

        header('location:' . HTTP_ROOT . EXCEL . $file_name);

        exit;
    }

    public function inventorySummary() {

        $this->loadModel('InUsers');

        $start_date = date('Y-m-d', strtotime($_GET['date']));

        $end_date = date('Y-m-d', strtotime($_GET['end_date']));

        if (!empty($_GET['date'])) {

            $this->InUsers->hasMany('men', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['men.profile_type' => 1, 'men.match_status' => 2, 'men.created >=' => $start_date, 'men.created <' => $end_date]);

            $this->InUsers->hasMany('women', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['women.profile_type' => 2, 'women.match_status' => 2, 'women.created >=' => $start_date, 'women.created <' => $end_date]);

            $this->InUsers->hasMany('boy', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['boy.profile_type' => 3, 'boy.match_status' => 2, 'boy.created >=' => $start_date, 'boy.created <' => $end_date]);

            $this->InUsers->hasMany('girl', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['girl.profile_type' => 4, 'girl.match_status' => 2, 'girl.created >=' => $start_date, 'girl.created <' => $end_date]);
        } else {

            $this->InUsers->hasMany('men', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['men.profile_type' => 1, 'men.match_status' => 2]);

            $this->InUsers->hasMany('women', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['women.profile_type' => 2, 'women.match_status' => 2]);

            $this->InUsers->hasMany('boy', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['boy.profile_type' => 3, 'boy.match_status' => 2]);

            $this->InUsers->hasMany('girl', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['girl.profile_type' => 4, 'girl.match_status' => 2]);
        }



        if (!empty($_GET['date'])) {

            $this->InUsers->hasMany('all_men', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['all_men.profile_type' => 1, 'all_men.created >=' => $start_date, 'all_men.created <' => $end_date]);

            $this->InUsers->hasMany('all_women', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['all_women.profile_type' => 2, 'all_women.created >=' => $start_date, 'all_women.created <' => $end_date]);

            $this->InUsers->hasMany('all_boy', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['all_boy.profile_type' => 3, 'all_boy.created >=' => $start_date, 'all_boy.created <' => $end_date]);

            $this->InUsers->hasMany('all_girl', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['all_girl.profile_type' => 4, 'all_girl.created >=' => $start_date, 'all_girl.created <' => $end_date]);
        } else {

            $this->InUsers->hasMany('all_men', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['all_men.profile_type' => 1]);

            $this->InUsers->hasMany('all_women', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['all_women.profile_type' => 2]);

            $this->InUsers->hasMany('all_boy', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['all_boy.profile_type' => 3]);

            $this->InUsers->hasMany('all_girl', ['className' => 'InProducts', 'foreignKey' => 'brand_id'])->setConditions(['all_girl.profile_type' => 4]);
        }



        $user_product_list = $this->InUsers->find('all')->contain(['men', 'women', 'boy', 'girl', 'all_men', 'all_women', 'all_boy', 'all_girl']);

        $this->set(compact('user_product_list', 'start_date', 'end_date'));
    }

    public function productScanUpdate() {

        $productEditDetails = [];

        if (!empty($_GET['product_value'])) {

            $value = trim($_GET['product_value']);

            $editproduct = $this->InProducts->find('all')->where(['InProducts.dtls' => $value])->first();

            if ($editproduct->profile_type == 1) {

                $profile = 'Men';
            }

            if ($editproduct->profile_type == 2) {

                $profile = 'Women';
            }

            if ($editproduct->profile_type == 3) {

                $profile = 'BoyKids';
            }

            if ($editproduct->profile_type == 4) {

                $profile = 'GirlKids';
            }

            $productType = $this->InProductType->find('all')->order(['id' => 'ASC']);

            $in_rack = $this->InRack->find('all')->where(['in_product_type_id' => $editproduct->product_type])->order(['id' => 'ASC']);

            $utype = $this->request->session()->read('Auth.User.type');

            $brandsListings = $this->InUsers->find('all')->where(['type' => 3])->order(['id']);
        }





        if ($this->request->is('post')) {



            $data = $this->request->data;

            // echo "<pre>";
            // print_r($data);
            // exit;



            if (!empty($data['quantity']) && ($data['quantity'] > 0)) {

                $data['match_status'] = 2;

                $data['available_status'] = 1;

                $data['is_deleted'] = 0;

                $data['quantity'] = 1;
            } else {

                $data['match_status'] = 1;

                $data['available_status'] = 2;

                $data['is_deleted'] = 0;

                $data['quantity'] = 0;
            }






            $data['updated_by'] = $this->request->session()->read('Auth.User.id');
            $data['updated_date'] = date('Y-m-d H:i:s');
            $data['action'] = 'scan_edit';

            $this->InProducts->updateAll($data, ['id' => $data['id']]);

            $newDtArr = [];

            $newDtArr['product_id'] = $data['id'];

            $newDtArr['user_id'] = $this->request->session()->read('Auth.User.id');

            $newDtArr['action'] = 'scan_edit';

            $newDtArr['created_on'] = date('Y-m-d H:i:s');

            $newDtArr['status'] = 2;

            $newDtRow = $this->InProductLogs->newEntity();

            $newDtRow = $this->InProductLogs->patchEntity($newDtRow, $newDtArr);

            $this->InProductLogs->save($newDtRow);

            $this->Flash->success(__('Data Updated successfully.'));

            return $this->redirect($this->referer());

//            print_r($data);
//            exit;
        }

        $this->set(compact('editproduct', 'profile', 'productType', 'in_rack', 'brandsListings', 'utype'));
    }

    public function editproductimgdelete($profile = null, $id = null) {



        $this->InProducts->updateAll(array('product_image' => NULL), array(['id' => $id]));

        $this->Flash->success(__('Image removed successfully.'));

        return $this->redirect($this->referer());
    }

    public function updateStyleNumber() {

        $all_prd = $this->InProducts->find('all');

        $ky = 0;

        foreach ($all_prd as $prd_li) {

            if (empty($prd_li->style_number)) {

                echo $ky++ . ' - ' . $prd_li->id . '<br>';

                $this->InProducts->updateAll(['style_number' => $prd_li->dtls], ['id' => $prd_li->id]);
            }
        }

        exit;
    }

    public function generateBarcode() {

        if ($this->request->is('post')) {

            $data = $this->request->data;

            $barcode_value = $data['bar_code'];

            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

            $dataImg = "data:image/png;base64," . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128));

            echo $barcode_value . '<br><br><img src="' . $dataImg . '"><br><a href="' . HTTP_ROOT . 'appadmins/generate_barcode/">Back</a>';

//            $resultimg = str_replace("data:image/png;base64,", "", $dataImg);
//            header('Content-Disposition: attachment;filename="'.$barcode_value.'.png"');
//            header('Content-Type: image/png');
//            echo base64_decode($resultimg);

            exit;
        }
    }

    public function missingFields() {

        $inv_user = $this->Users->find('all')->where(['type' => 7]);
        $type = $this->request->session()->read('Auth.User.type');
        if ($type == 7) {
            $user_id = $this->request->session()->read('Auth.User.id');
            $inv_user = $inv_user->where(['id' => $user_id]);
        }
        $all_prod_list = [];

        if (!empty($_GET['employee'])) {

            if ($type == 7) {
                if ($user_id != $_GET['employee']) {
                    $this->Flash->error(__('Invalid request.'));
                    return $this->redirect(HTTP_ROOT . 'appadmins/missing_fields');
                }
            }

            $all_employee_prds = $this->InProductLogs->find('all')->where(['user_id' => $_GET['employee']]);

            if (!empty($_GET['action']) && !empty($_GET['action'])) {

                $all_employee_prds = $all_employee_prds->where(['InProductLogs.action' => $_GET['action']]);
            }

            if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {

                $start_date = date('Y-m-d', strtotime($_GET['start_date']));

                $end_date = date('Y-m-d', strtotime($_GET['end_date']));

                $all_employee_prds = $all_employee_prds->where([
                            'InProductLogs.created_on BETWEEN :start AND :end'
                        ])
                        ->bind(':start', $start_date, 'datetime')
                        ->bind(':end', $end_date, 'datetime');
            } else if (!empty($_GET['start_date'])) {

                $start_date = date('Y-m-d', strtotime($_GET['start_date']));

                $all_employee_prds = $all_employee_prds->where(['InProductLogs.created_on LIKE' => '%' . $start_date . '%']);
            }

            //  pr($all_employee_prds);
            //     exit;



            $all_product_ids = !empty($all_employee_prds) ? Hash::extract($all_employee_prds->toArray(), '{n}.product_id') : [];

            if (!empty($all_product_ids)) {

                $this->InProducts->belongsTo('rak', ['className' => 'InRack', 'foreignKey' => 'rack']);

                $this->InProducts->belongsTo('ctg', ['className' => 'InProductType', 'foreignKey' => 'product_type']);

                $this->InProducts->hasMany('emp_log', ['className' => 'InProductLogs', 'foreignKey' => 'product_id'])->setConditions(['emp_log.user_id' => $_GET['employee']]);

                $all_prod_listx = $this->InProducts->find('all')->where(['InProducts.id IN' => $all_product_ids])->contain(['emp_log', 'ctg', 'rak']);

                if (!empty($_GET['user_type'])) {

                    $all_prod_listx = $all_prod_listx->where(['profile_type' => $_GET['user_type']]);
                }



//                $all_prod_listx = $all_prod_listx->group('InProducts.prod_id');

                $all_prod_list = $this->paginate($all_prod_listx);
            }
        }



        if ($this->request->is('post')) {

            $data = $this->request->getData();

            $cus_id = explode(',', $data['id']);

            $this->InProductLogs->updateAll(['rework_flds' => $data['rework_flds'], 'status' => '4'], ['id IN' => $cus_id]);

            $this->Flash->success(__('Task updated to rework.'));

            return $this->redirect($this->referer());
        }



        $this->set(compact('inv_user', 'all_prod_list', 'all_prod_list'));
    }

    public function task() {

        // echo date('Y-m-d H:i:s');exit;

        $user_id = $this->request->session()->read('Auth.User.id');

        $this->InProductLogs->belongsTo('prd_dtl', ['className' => 'InProducts', 'foreignKey' => 'product_id']);

        $all_employee_wrk_prds = $this->InProductLogs->find('all')->where(['InProductLogs.user_id' => $user_id, 'InProductLogs.created_on LIKE' => '%' . date('Y-m-d') . '%'])->contain(['prd_dtl'])->order(['InProductLogs.id' => 'DESC']);

//        print_r($all_employee_wrk_prds);exit;

        $all_prod_list = $this->paginate($all_employee_wrk_prds);

        if ($this->request->is('post')) {

            $user_id = $this->request->session()->read('Auth.User.id');

            $data = $this->request->getData();

            $employee_id = $this->request->session()->read('Auth.User.id');

            $all_employee_prds = $this->InProductLogs->find('all')->where(['user_id' => $employee_id, 'status' => 2]);

            $all_product_ids = !empty($all_employee_prds) ? Hash::extract($all_employee_prds->toArray(), '{n}.product_id') : [];

            $this->InProductLogs->updateAll(['status' => 3], ['status' => 2, 'product_id IN' => $all_product_ids, 'user_id' => $employee_id]);

            $this->Flash->success(__('Task sent to review.'));

            return $this->redirect($this->referer());
        }





        $this->set(compact('all_prod_list'));
    }

    public function rework() {

        $employee_id = $this->request->session()->read('Auth.User.id');

        $all_employee_prds = $this->InProductLogs->find('all')->where(['user_id' => $employee_id, 'status' => 4]);

        $all_product_ids = !empty($all_employee_prds) ? Hash::extract($all_employee_prds->toArray(), '{n}.product_id') : [];

        $this->InProducts->hasMany('emp_log', ['className' => 'InProductLogs', 'foreignKey' => 'product_id'])->setConditions(['emp_log.user_id' => $employee_id]);

        $all_prod_list = $this->InProducts->find('all')->where(['InProducts.id IN' => $all_product_ids])->contain(['emp_log']);

        $this->set(compact('all_product_ids', 'all_prod_list'));
    }

    public function approveEmployeeWork() {



        if ($this->request->is('post')) {

            $data = $this->request->getData();

            $all_ids = explode(',', $data['id']);

            $this->InProductLogs->updateAll(['status' => 1], ['id IN' => $all_ids]);

            $all_employee_prds = $this->InProductLogs->find('all')->where(['id IN' => $all_ids]);

            $all_product_ids = !empty($all_employee_prds) ? Hash::extract($all_employee_prds->toArray(), '{n}.product_id') : [];

            $this->InProducts->updateAll(['is_active' => 1, 'available_status' => 1], ['id IN' => $all_product_ids]);
        }

        $this->Flash->success(__('Task approved.'));

        return $this->redirect($this->referer());
    }
}
