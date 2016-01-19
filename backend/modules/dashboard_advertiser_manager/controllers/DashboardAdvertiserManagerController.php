<?php

class DashboardAdvertiserManagerController extends AdvertiserManagerController {

  public function __construct() {
    parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
  }

  public function showIndex() {
    $this->data['defaultField'] = $this->defaultField;
    $this->data['defaultOrder'] = $this->defaultOrder;
    $this->data['defaultURL'] = $this->moduleURL;
    $this->layout->content = View::make('index', $this->data);
  }

  function getDashboard() {
    $flight_dates = FlightDateBaseModel::with("flight.campaign")->where("start", "<=", date("Y-m-d"))->Where("end", ">=", date("Y-m-d"))->orderBy("flight_id", "DESC")->get();
    $data["data"] = array();

    $campaignIds = null;
    $flightIds = null;
    $adIds = null;

    foreach ($flight_dates as $flight_date) {
      $flight = $flight_date->flight;
      $campagin = $flight->campaign;

      $campaignIds[] = $flight->campaign->id;
      $flightIds[] = $flight->id;
      $adIds[] = $flight->ad_id;

      $flight->daily_inventory = $flight_date->daily_inventory;
      if ($flight->cost_type == 'cpm') {
        $flight->daily_inventory = $flight_date->daily_inventory * 1000;
      }
      $data["datas"][$campagin->name][$flight->id] = $flight;
    }

    $totalInventories = TrackingSummaryBaseModel::getFlightSummaryByIDs($flightIds);
    $data['totalInventories'] = $totalInventories;
    return View::make('dashboard', $data);
  }

  function getDashboardHQ() {
    $flight_dates = FlightDateBaseModel::with('flight.campaign')->where("start", "<=", date("Y-m-d"))->Where("end", ">=", date("Y-m-d"))->orderBy("flight_id", "DESC")->get();
    $data["data"] = array();

    $campaignIds = null;
    $flightIds = null;
    $adIds = null;


    foreach ($flight_dates as $flight_date) {
      $flight = $flight_date->flight;
      $campagin = $flight->campaign;

      $campaignIds[] = $flight->campaign->id;
      $flightIds[] = $flight->id;
      $adIds[] = $flight->ad_id;

      $flight->daily_inventory = $flight_date->daily_inventory;
      if ($flight->cost_type == 'cpm') {
        $flight->daily_inventory = $flight_date->daily_inventory * 1000;
      }
      $data["datas"][$campagin->name][$flight->id] = $flight;
    }
    $dailyInventories = FlightBaseModel::getDailyInventories($campaignIds, $flightIds, $adIds);
    $totalInventories = TrackingSummaryBaseModel::getFlightSummaryByIDs($flightIds);
    //var_dump($totalInventories); die();
    $data['dailyInventories'] = $dailyInventories;
    $data['totalInventories'] = $totalInventories;
    return View::make('dashboard_hq', $data);
  }

  public function loadLastCampaignChart() {
    $limit = Input::get('limit');
    $modelCampaign = new CampaignBaseModel;
    $listCampaign = $modelCampaign->getCampaignRecent($limit);
    $listCampaignID = array_column($listCampaign->toArray(), 'id');
    $listCampaignChart = array();

    $trackingSummaryModel = new TrackingSummaryBaseModel;
    if (!empty($listCampaignID)) {
      foreach ($listCampaignID as $campaign) {
        $listCampaignChart[$campaign] = $trackingSummaryModel->getFlightChart($campaign)->toArray();
      }
    }

    $this->data['listCampaign'] = $listCampaign;
    $this->data['listCampaignChart'] = $listCampaignChart;

    return View::make('campaignChart', $this->data)->render();
  }

  public function showPublisher() {
    $start_date = (Input::get('start_date')) ? date("Y-m-d", strtotime(Input::get('start_date'))) : date('Y-m-d');
    $end_date = (Input::get('end_date')) ? date("Y-m-d", strtotime(Input::get('end_date'))) : date('Y-m-d');
    $website = Input::get('website');
    $adformat = Input::get('adformat');
    $this->data['lists_website'] = PublisherSiteBaseModel::where("status", '=', 1)->get();
    $this->data['lists_adfortmat'] = AdFormatBaseModel::get();
    $tracking = DB::connection('mongodb')->collection('trackings_summary')->where("created_d", '>=', $start_date)->where("created_d", '<=', $end_date);

    if ($website != "") {
      $tracking = $tracking->where('w', '=', (int) $website);
    }
    if ($adformat != "") {
      $tracking = $tracking->where('af', '=', (int) $adformat);
    }

    $tracking = $tracking->get();
    $list_site = array();
    $list_zone = array();
    $data_ok = array();
    if (!empty($tracking)) {
      foreach ($tracking as $tract) {
        if (isset($tract['ads_request'])) {
          if (!isset($list_site[$tract['w']])) {
            $site = PublisherSiteBaseModel::find($tract['w']);
            if ($site) {
              $list_site[$tract['w']] = $site;
            } else {
              continue;
            }
          }
          if (!isset($list_zone[$tract['az']])) {
            $adzone = PublisherAdZoneBaseModel::find($tract['az']);
            if ($adzone) {
              $list_zone[$tract['az']] = $adzone;
            } else {
              continue;
            }
          }
          if (isset($tract['f'])) {
            $data_ok[$tract['w']][$tract['az']]['ads'][] = $tract['ads_request'];
          } else {
            $data_ok[$tract['w']][$tract['az']]['noads'][] = $tract['ads_request'];
          }
        }
      }
    }
    $this->data['list_zone'] = $list_zone;
    $this->data['list_site'] = $list_site;
    $this->data['data_ok'] = $data_ok;
    $this->data['start_date'] = date("m/d/Y", strtotime($start_date));
    $this->data['end_date'] = date("m/d/Y", strtotime($end_date));
    $this->data['website'] = $website;
    $this->data['adformat'] = $adformat;

    $this->layout->content = View::make('publisher', $this->data);
  }

}
