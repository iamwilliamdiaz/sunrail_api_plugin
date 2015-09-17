<?php

class SUNRAIL_API_Introspector {
  


    public function get_current_stations($limit) {

        $station = new SUNRAIL_API_Station();
        $stationlists= $station->getStations($limit);
        return $stationlists;

    }

    public function get_current_pointofinterest($limit) {

        $pois = new SUNRAIL_API_Poi();
        $poislists= $pois->getPOIs($limit);
        return $poislists;

    }

    public function get_current_parkings($limit) {

        $parkings = new SUNRAIL_API_Parking();
        $parkingslists= $parkings->getParkings($limit);
        return $parkingslists;

    }


    public function get_current_alerts($limit) {

        $alerts = new SUNRAIL_API_Alert();
        $alertslists= $alerts->getAlerts($limit);
        return $alertslists;

    }

    public function get_current_schedules($limit) {

        $schedules = new SUNRAIL_API_Schedule();
        $scheduleslists= $schedules->getSchedules($limit);
        return $scheduleslists;

    }


    public function get_current_token() {

        $tokenizer = new SUNRAIL_API_Tokenizer();
        $token= $tokenizer->getToken();
        return $token;

    }



}


