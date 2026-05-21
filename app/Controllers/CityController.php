<?php

namespace App\Controllers;

use App\Models\CityModel ;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class CityController extends BaseController{
        protected $helpers = ['encryption'];
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
                $data = $this->request->getJSON(true);
                $cityName= $data["name"];
                $state_id = $data['state_id'];
                $state_id = decryptId($state_id);
                $result = $this->cityModel->insert(['name'=>$cityName,'state_id'=>$state_id]);

                if($result){
                    $this->response->setStatusCode(201)->setJSON([
                        'status'=> true,
                        'message'=> "City Created Successfully"
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


        public function updateCity($id){
            try{
                $id = decryptId($id);
                $updatedData = $this->request->getJSON(true);

                $newData = $this->cityModel->update($id,['name'=>$updatedData['updatedCityName']]);
                if($newData){
                    return $this->response->setStatusCode(201)->setJSON([
                        'status'=>true,
                        'message'=>'City updatedet successfully'
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

        public function getCityByState($id) {
            try{
                $id = decryptId($id);
                $allCity = $this->cityModel
                ->select('cities.*, states.state as state_name')
                ->join('states', 'states.id = cities.state_id')
                ->findAll();
                $allCity=encryptIds($allCity);
                return $this->response->setStatusCode(200)->setJSON([
                    "data"=>$allCity,
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


        public function deleteCity($id){
            try{
                $id = decryptId($id);
                $state = $this->cityModel->find($id);
                if(!$state) return $this->response->setStatusCode(404)->setJSON([
                    "success"=>false,
                    "message"=> "City Not Found"
                ]);

                $isDelete = $this->cityModel->delete($id);

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