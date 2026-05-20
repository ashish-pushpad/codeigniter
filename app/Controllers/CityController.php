<?php

namespace App\Controllers;

use App\Models\CityModel ;

class CityController extends BaseControlle{
        protected  $cityModel;
        public function initController(
            RequestInterface $request,
            ResponseInterface $response, 
            LoggerInterface $logger,
        ){
            parent::initController($request, $response, $logger);
            $this->cityModel =new cityModel();
        }



        public function addCity(){
            try{
                $cityName= $this->request->getPost("name");
                $state_id = $this->request->getPost('state_id');

                $result = $this->cityModel->insert(['name'=>$cityName,'state_id'=>$state_id]);

                if($result){
                    $this->response->setStatusCode(201)->setJSON([
                        'status'=> true,
                        'message'=> "City Created Successfully"
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


        public function updateCity($id){
            try{
                $updatedData = $this->request->getPost("updatedCityName");

                $newData = $this->cityModel->update($id,['state'=>$updatedData]);
                if($newData){
                    return $this->response->setStatusCode(201)->setJSON([
                        'status'=>true,
                        'message'=>'City updatedet successfully'
                    ]);
                }

            }catch(\Exception  $e){
                log_message("Error to updatecity",$e->getMessage());
                return $this->response->setStatusCode(500)->setJSON([
                    'success'=>false,
                    'message'=>"Internal Server Error"
                ]);
            }

        }

        public function getCityByState($id) {
            try{
                $allStates = $this->cityModel
                ->select('cities.*, states.state as state_name')
                ->join('state', 'states.id = city.state_id')
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
                $state = $this->cityModel->find($id);
                if(!$state) return $this->response->setStatusCode(404)->setJSON([
                    "success"=>false,
                    "message"=> "City Not Found"
                ]);

                $isDelete = $this->cityModel->delete($id);

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