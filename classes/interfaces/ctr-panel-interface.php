<?php 

  interface CtrPanelInterface{
    public function getRoomAllocStatus($currentSessionStudentId);
    public function getAllocatedRoomNo($currentSessionStudentId);
    public function getRoomAllocRoomMates($roomNo, $currentSessionStudentId);
    public function getRequestRoomStatus($currentSessionStudentId);
    public function getRoomMateStatus($currentSessionStudentId);
    public function getRoomMates($currentSessionStudentId);
    public function getRoomRequestDate($currentSessionStudentId);
    public function getRequestStudentId($currentSessionStudentId);
    public function getMyRoomMates($requestStudentId, $currentSessionStudentId);
    public function getRequestRoomMateData($requestStudentId);
    public function getRoomMateConfirmStatus($currentSessionStudentId);
    public function getNumOfRoomMates($roomNo);
    public function getRoomRequest($currentSessionStudentId);
  }