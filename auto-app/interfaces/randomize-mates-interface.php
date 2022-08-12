<?php 

  interface RandomizeMatesInterface {
    public function isFreeMate($studentId);
    public function isFreeMateTwo($studentId);
    public function registerRequest($studentId);
    public function registerPreferredRoomMates($studentId, $roomMateId);
    public function registerRequests($studentId);
    public function registerResponses($studentId, $response);
    
    public function getRequestRoomTable();
    public function getPreferredRoomMates();
    public function getRequestsTable();
  }