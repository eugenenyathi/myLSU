<?php 

  interface ResetInterface{
    public function resetRequestsTable();
    public function resetRequestRoomTable();
    public function resetRequestsTableTwo();
    public function resetRequestRoomTableTwo();
    
    
    public function resetPreferredRoomMates();
    public function resetRoomOccupiersTable();
    public function resetRoomAvailabityStatus();
    
    public function getRequestsTable();
    public function getRequestRoomTable();
    public function getPreferredRoomMates();
  }