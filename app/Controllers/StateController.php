<?php
namespace App\Controllers;

use App\Models\StatesModel ;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class StateController extends BaseController{
        protected $helpers = ['encryption'];
        protected  $stateModel;
        public function initController(
            RequestInterface $request,
            ResponseInterface $response, 
            LoggerInterface $logger,
        ){
            parent::initController($request, $response, $logger);
            $this->stateModel = new StatesModel();
        }



        public function addState(){
            try{
                $stateName= $this->request->getPost("satateName");
                $countary_id = $this->request->getPost('countary_id');
                $countary_id = decryptId($countary_id);
                $result = $this->stateModel->insert(['state'=>$stateName,'country_id'=>$countary_id]);

                if($result){
                    $this->response->setStatusCode(201)->setJSON([
                        'status'=> true,
                        'message'=> "State Created Successfully"
                    ]);
                }
            }catch (\Exception $e){
                log_message('error',$e->getMessage());
                return $this->response->setStatusCode(500)->setJSON([
                    "status"=>false,
                    "message"=>"Server Error"
                ]);
            }
        }


        public function updateState($id){
            try{
                $id = decryptId($id);
                $updatedData = $this->request->getRawInput();

                $newData = $this->stateModel->update($id,['state'=>$updatedData]);
                if($newData){
                    return $this->response->setStatusCode(201)->setJSON([
                        'status'=>true,
                        'message'=>'state updatedet successfully',
                        'data'=>$newData
                    ]);
                }

            }catch(\Exception  $e){
                log_message("error",$e->getMessage());
                return $this->response->setStatusCode(500)->setJSON([
                    'success'=>false,
                    'message'=>"Internal Server Error"
                ]);
            }

        }

        public function getStateByCountry($id) {
            try{
                $id = decryptId($id);
                $allStates = $this->stateModel
                ->select('states.*, countries.name as country_name')
                ->join('countries', 'countries.id = states.country_id')
                ->findAll();
                $allStates=encryptIds($allStates);
                return $this->response->setStatusCode(200)->setJSON([
                    "data"=>$allStates,
                    'success'=>true
                ]);
    
            }catch(\Exception $e){
                log_message("error",$e->getMessage());
                return $this->response->setStatusCode(500)->setJSON([
                    'status'=>false,
                    'message'=>"Internal Server Error"
                ]);
            }
        }


        public function deleteState($id){
            try{
                $id = decryptId($id);
                $state = $this->stateModel->find($id);
                if(!$state) return $this->response->setStatusCode(404)->setJSON([
                    "success"=>false,
                    "message"=> "Data Not Found"
                ]);

                $isDelete = $this->stateModel->delete($id);

                return $this->response->setStatusCode(200)->setJSON([
                    'success'=>true,
                    'message'=>'data deleted successfully',
                    'data'=> $isDelete
                ]);

            }catch(\Exception $e){
                log_message("error",$e->getMessage());
                return $this->response->setStatusCode(500)->setJSON([
                    'success'=>false,
                    'message'=>"Internal Server Error Try Again Later !!"
                ]);
            }
        }
}