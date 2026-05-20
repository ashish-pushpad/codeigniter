<?php

namespace App\Controllers;

use App\Models\CountaryModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class CountaryController extends BaseController{
        protected  $countaryModel;
        protected $helpers = ['encryption'];
        public function initController(
            RequestInterface $request,
            ResponseInterface $response, 
            LoggerInterface $logger
        ){
            parent::initController($request, $response, $logger);
            $this->countaryModel =new CountaryModel();
        }



        public function addCountary(){
            try{
                $countaryName= $this->request->getPost("countaryName");
                $isExist = $this->countaryModel->where(['name'=>$countaryName])->first();
                if($isExist) return $this->response->setStatusCode(400)->setJSON([
                    'success'=>false,
                    'message'=>"Countary with similar name is exist"
                ]);
                $result = $this->countaryModel->insert(['name'=>$countaryName]);

                if($result){
                    $this->response->setStatusCode(201)->setJSON([
                        'status'=> true,
                        'message'=> "countary Created Successfully"
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


        public function updateCountary($id){
            try{
                $id = decryptId($id);
                $updatedData = $this->request->getRawInput();
                $isExist = $this->countaryModel->where(['name'=>$updatedData['countaryName']])->first();
                if($isExist) return $this->response->setStatusCode(400)->setJSON([
                    'success'=>false,
                    'message'=> "Countary with similar name is exist"
                ]);

                $newData = $this->countaryModel->update($id,['name'=>$updatedData]);
                if($newData){
                    return $this->response->setStatusCode(200)->setJSON([
                        'status'=>true,
                        'message'=>'Countary updatedet successfully'
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

        public function getCountries() {
            try{
                $allCountary = $this->countaryModel->findAll();
                    $allCountary=encryptIds($allCountary);
                    return $this->response->setStatusCode(200)->setJSON([
                        "data"=>$allCountary,
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


        public function deleteCountary($id){
            try{$id = decryptId($id);
                $country = $this->countaryModel->find($id);
                if(!$country) return $this->response->setStatusCode(404)->setJSON([
                    "success"=>false,
                    "message"=> "Data Not Found"
                ]);

                $isDelete = $this->countaryModel->delete($id);

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