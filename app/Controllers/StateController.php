<?php

namespace App\Controllers;

use App\Models\StateModel ;

class StateController extends BaseControlle{
        protected  $stateModel;
        public function initController(
            RequestInterface $request,
            ResponseInterface $response, 
            LoggerInterface $logger,
        ){
            parent::initController($request, $response, $logger);
            $this->stateModel =new StateModel();
        }



        public function addState(){
            try{
                $stateName= $this->request->getPost("satateName");
                $countary_id = $this->request->getPost('countary_id');

                $result = $this->stateModel->insert(['state'=>$stateName,'countary_id'=>$countary_id]);

                if($result){
                    $this->response->setStatusCode(201)->setJSON([
                        'status'=> true,
                        'message'=> "State Created Successfully"
                    ]);
                }
            }catch (\Exception $e){
                log_message('Error',$e->getMessage());
                return $this->response->setStatusCode(500)->setJSON([
                    "status"=>false,
                    "message"=>"Server Error"
                ]);
            }
        }


        public function updateState($id){
            try{
                $updatedData = $this->request->getPost("updatedStateName");
                $isExist = $this->stateModel->where(['state',$updatedData])->first();
                if($isExist) return $this->response->setStatusCode(400)->setJSON([
                    'success'=>false,
                    'message'=> "State with similar name is exist"
                ]);

                $newData = $this->stateModel->update($id,['state'=>$updatedData]);
                if($newData){
                    return $this->response->setStatusCode(201)->setJSON([
                        'status'=>true,
                        'message'=>'state updatedet successfully'
                    ]);
                }

            }catch(\Exception  $e){
                log_message("Error to updateState ",$e->getMessage());
                return $this->response->setStatusCode(500)->setJSON([
                    'success'=>false,
                    'message'=>"Internal Server Error"
                ]);
            }

        }

        public function getStateByCountry($id) {
            try{
                $allStates = $this->stateModel
                ->select('states.*, countries.name as country_name')
                ->join('countries', 'countries.id = states.country_id')
                ->findAll();

                return $this->response->setStatusCode(200)->setJSON([
                    "data"=>$allStates,
                    'success'=>true
                ]);
    
            }catch(\Exception $e){
                log_message("Error to getStateByCountry ",$e.getMessage());
                return $this->response->setStatusCode(500)->setJSON([
                    'status'=>false,
                    'message'=>"Internal Server Error"
                ]);
            }
        }


        public function deleteState($id){
            try{
                $state = $this->stateModel->find($id);
                if(!$state) return $this->response->setStatusCode(404)->setJSON([
                    "success"=>false,
                    "message"=> "Data Not Found"
                ]);

                $isDelete = $this->stateModel->delete($id);

                return $this->response->setStatusCode(200)->setJSON([
                    'success'=>true,
                    'message'=>'data deleted successfully',
                    'data'=> $isDeleted
                ]);

            }catch(\Exception $e){
                log_message("Error to Delete the State ",$e->getMessage());
                return $this->response->setStatusCode(500)->setJSON([
                    'success'=>false,
                    'message'=>"Internal Server Error Try Again Later !!"
                ]);
            }
        }
}