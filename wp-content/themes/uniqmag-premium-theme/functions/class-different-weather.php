<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Weather {

	var $weather_set = false;
	var $location_type = false;
	var $weather_type = false;
	var $weather = false;
	var $options;


	public function __construct() {
		$this->options = New Different_Themes_Options();
		//check if weather forecast is enabled
		$this->weather_set = $this->options->get(THEME_NAME."_weather");

		//get weather forecast type - custom location or static
		$this->location_type = $this->options->get(THEME_NAME."_weather_location_type");
		if($this->location_type == "custom") {
			$this->weather_type = str_replace(' ', '+', $this->options->get(THEME_NAME."_weather_city"));
		} else {
			$this->weather_type = $_SERVER['REMOTE_ADDR'];
		}

		$this->forecast();
	}

    /**
     * returns weather forecast data
     * @return array
     */
	public function forecast() {
		$Different_Themes_Other = new Different_Themes_Other();

		if($this->location_type == "custom") {
			$whitelist = array();
		} else {
			$whitelist = array('localhost', '127.0.0.1');
		}

		$weather_api = $this->options->get(THEME_NAME."_weather_api");
		$weather_api_key_type = $this->options->get(THEME_NAME."_weather_api_key_type");

		if($weather_api) {
			if(!in_array($_SERVER['HTTP_HOST'], $whitelist)){
				if($this->location_type == "custom") {
					$result = true;
				} else {
					$url = "http://www.geoplugin.net/json.gp?ip=".$this->weather_type;
					$result = $Different_Themes_Other->json_response($url);
				}

				if($result!=false) {
					if($this->location_type == "custom") {
						$city = false;
						$country = false;
						$weatherResult = get_transient('weather_result_'.urlencode($this->weather_type));
					} else {
						$city = $result->geoplugin_city;
						$country = $result->geoplugin_countryName;
						$weatherResult = get_transient('weather_result_'.urlencode($city).'_'.urlencode($country));
					}

					
					if($weatherResult==false) {
						$temperature = $this->options->get(THEME_NAME."_temperature");
						

						if($city) {
							if($weather_api_key_type=="premium") {
								$url = "http://api.worldweatheronline.com/premium/v2/weather.ashx?key=".$weather_api."&q=".urlencode($city).",".urlencode($country)."&num_of_days=1&includeLocation=yes&date=today&format=json";
							} else {
								$url = "http://api.worldweatheronline.com/free/v2/weather.ashx?key=".$weather_api."&q=".urlencode($city).",".urlencode($country)."&num_of_days=1&includeLocation=yes&date=today&format=json";
							}				
							$result = $Different_Themes_Other->json_response($url);
						} else {
							if($weather_api_key_type=="premium") {
								$url = "http://api.worldweatheronline.com/premium/v2/weather.ashx?key=".$weather_api."&q=".$ip."&num_of_days=1&includeLocation=yes&date=today&format=json";
							} else {
								$url = "http://api.worldweatheronline.com/free/v2/weather.ashx?key=".$weather_api."&q=".$ip."&num_of_days=1&includeLocation=yes&date=today&format=json";
							}
							$result = $Different_Themes_Other->json_response($url);
						}
					
						if($result!=false) {
							$weather = array();

				
							$weather['temp_F'] = $result->data->current_condition[0]->temp_F;	
							$weather['temp_C'] = $result->data->current_condition[0]->temp_C;
							

							// temperature color
							if ($weather['temp_C'] <= -25) {
								$weather['color'] = "reg-cold";
							} else if ($weather['temp_C'] > -25 && $weather['temp_C'] < -10) {
								$weather['color'] = "reg-cold";
							} else if ($weather['temp_C'] >= -10 && $weather['temp_C'] <= 4) {
								$weather['color'] = "reg-cold";
							} else if ($weather['temp_C'] > 5 && $weather['temp_C'] < 25) {
								$weather['color'] = "reg-normal";
							}  else if ($weather['temp_C'] >= 25) {
								$weather['color'] = "reg-hot";
							} 
							
							// add + before 
							$weather['temp_F'] = intval($weather['temp_F']);
							if($weather['temp_F']>0) {
								$weather['temp_F'] = "+".$weather['temp_F'];
							} else {
								$weather['temp_F'];
							}				

							// add + before 
							$weather['temp_C'] = intval($weather['temp_C']);
							if($weather['temp_C']>0) {
								$weather['temp_C'] = "+".$weather['temp_C'];
							} else {
								$weather['temp_C'];
							}

							$weather['temp_F'] = esc_html($weather['temp_F'].'&deg;F');
							$weather['temp_C'] = esc_html($weather['temp_C'].'&deg;C');

					
							$weather['temp'] = $weather['temp_'.$this->options->get(THEME_NAME."_temperature")];
							

							$weatherCode = esc_html($result->data->current_condition[0]->weatherCode);
							$weather['city'] = esc_html($result->data->nearest_area[0]->areaName[0]->value);
							$weather['country'] = esc_html($result->data->nearest_area[0]->country[0]->value);


							switch ($weatherCode) {
								case '395':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Moderate or heavy snow in area with thunder','uniqmag');
									break;
								case '392':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Patchy light snow in area with thunder','uniqmag');
									break;
								case '371':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Moderate or heavy snow showers','uniqmag');
									break;
								case '368':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Light snow showers','uniqmag');
									break;
								case '350':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Ice pellets','uniqmag');
									break;
								case '338':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Heavy snow','uniqmag');
									break;
								case '335':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Patchy heavy snow','uniqmag');
									break;
								case '332':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Moderate snow','uniqmag');
									break;
								case '329':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Patchy moderate snow','uniqmag');
									break;
								case '326':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Light snow','uniqmag');
									break;
								case '323':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Patchy light snow','uniqmag');
									break;
								case '320':
									$weather['image'] = "sleet";
									$weather['weatherDesc'] = esc_html__('Moderate or heavy sleet','uniqmag');
									break;
								case '317':
									$weather['image'] = "sleet";
									$weather['weatherDesc'] = esc_html__('Light sleet','uniqmag');
									break;
								case '284':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Heavy freezing drizzle','uniqmag');
									break;
								case '281':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Freezing drizzle','uniqmag');
									break;
								case '266':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Light drizzle','uniqmag');
									break;
								case '263':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Patchy light drizzle','uniqmag');
									break;
								case '230':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Blizzard','uniqmag');
									break;
								case '227':
									$weather['image'] = "snow";
									$weather['weatherDesc'] = esc_html__('Blowing snow','uniqmag');
									break;
								case '389':
									$weather['image'] = "thunderstorm";
									$weather['weatherDesc'] = esc_html__('Moderate or heavy rain in area with thunder','uniqmag');
									break;
								case '386':
									$weather['image'] = "thunderstorm";
									$weather['weatherDesc'] = esc_html__('Patchy light rain in area with thunder','uniqmag');
									break;
								case '200':
									$weather['image'] = "thunderstorm";
									$weather['weatherDesc'] = esc_html__('Thundery outbreaks in nearby','uniqmag');
									break;
								case '377':
									$weather['image'] = "rain-mix";
									$weather['weatherDesc'] = esc_html__('Moderate or heavy showers of ice pellets','uniqmag');
									break;
								case '374':
									$weather['image'] = "showers";
									$weather['weatherDesc'] = esc_html__('Light showers of ice pellets','uniqmag');
									break;
								case '365':
									$weather['image'] = "sleet";
									$weather['weatherDesc'] = esc_html__('Moderate or heavy sleet showers','uniqmag');
									break;
								case '362':
									$weather['image'] = "sleet";
									$weather['weatherDesc'] = esc_html__('Light sleet showers','uniqmag');
									break;
								case '359':
									$weather['image'] = "rain";
									$weather['weatherDesc'] = esc_html__('Torrential rain shower','uniqmag');
									break;
								case '356':
									$weather['image'] = "rain";
									$weather['weatherDesc'] = esc_html__('Moderate or heavy rain shower','uniqmag');
									break;
								case '353':
									$weather['image'] = "showers";
									$weather['weatherDesc'] = esc_html__('Light rain shower','uniqmag');
									break;
								case '314':
									$weather['image'] = "wi-rain-mix";
									$weather['weatherDesc'] = esc_html__('Moderate or Heavy freezing rain','uniqmag');
									break;
								case '311':
									$weather['image'] = "wi-rain-mix";
									$weather['weatherDesc'] = esc_html__('Light freezing rain','uniqmag');
									break;
								case '308':
									$weather['image'] = "storm-showers";
									$weather['weatherDesc'] = esc_html__('Heavy rain','uniqmag');
									break;
								case '305':
									$weather['image'] = "rain";
									$weather['weatherDesc'] = esc_html__('Heavy rain at times','uniqmag');
									break;
								case '302':
									$weather['image'] = "rain";
									$weather['weatherDesc'] = esc_html__('Moderate rain','uniqmag');
									break;
								case '299':
									$weather['image'] = "rain";
									$weather['weatherDesc'] = esc_html__('Moderate rain at times','uniqmag');
									break;
								case '296':
									$weather['image'] = "showers";
									$weather['weatherDesc'] = esc_html__('Light rain','uniqmag');
									break;
								case '293':
									$weather['image'] = "showers";
									$weather['weatherDesc'] = esc_html__('Patchy light rain','uniqmag');
									break;
								case '185':
									$weather['image'] = "rain-mix";
									$weather['weatherDesc'] = esc_html__('Patchy freezing drizzle nearby','uniqmag');
									break;
								case '179':
									$weather['image'] = "rain-mix";
									$weather['weatherDesc'] = esc_html__('Patchy snow nearby','uniqmag');
									break;
								case '176':
									$weather['image'] = "showers";
									$weather['weatherDesc'] = esc_html__('Patchy rain nearby','uniqmag');
									break;
								case '260':
									$weather['image'] = "fog";
									$weather['weatherDesc'] = esc_html__('Freezing fog','uniqmag');
									break;
								case '248':
									$weather['image'] = "fog";
									$weather['weatherDesc'] = esc_html__('Fog','uniqmag');
									break;
								case '143':
									$weather['image'] = "cloudy";
									$weather['weatherDesc'] = esc_html__('Mist','uniqmag');
									break;
								case '122':
									$weather['image'] = "cloudy";
									$weather['weatherDesc'] = esc_html__('Overcast','uniqmag');
									break;
								case '119':
									$weather['image'] = "cloudy";
									$weather['weatherDesc'] = esc_html__('Cloudy','uniqmag');
									break;
								case '116':
									$weather['image'] = "cloudy";
									$weather['weatherDesc'] = esc_html__('Partly Cloudy','uniqmag');
									break;
								case '113':
									$weather['image'] = "day-sunny";
									$weather['weatherDesc'] = esc_html__('Sunny','uniqmag');
									break;
								case '182':
									$weather['image'] = "sleet";
									$weather['weatherDesc'] = esc_html__('Patchy sleet nearby','uniqmag');
									break;
								default:
									$weather['image'] = false;
									$weather['weatherDesc'] = esc_html__('Can\'t get any data.','uniqmag');
									break;
							}


							//set wp cache
							if($this->location_type == "custom") {
								set_transient('weather_result_'.urlencode($ip), $weather, 3600 );
							} else {
								set_transient( 'weather_result_'.urlencode($city).'_'.urlencode($country), $weather, 3600 );
							}
							
						} else {
							$weather['error'] = esc_html__("Something went wrong with the connection!",'uniqmag');
						}
					} else {
						//get wp cache
						if($this->location_type == "custom") {
							$weather = get_transient('weather_result_'.urlencode($ip));
						} else {
							$weather = get_transient('weather_result_'.urlencode($city).'_'.urlencode($country));
						}

					}
				} else {
					$weather['error'] = esc_html__("Something went wrong with the connection!",'uniqmag');
				}
			} else {
				$weather['error'] = esc_html__("This option doesn't work on localhost!",'uniqmag');
			}
		} else {

			$weather['error'] = esc_html__("Please set up your API key!",'uniqmag');

		}

		$this->weather = $weather;
		
	}
}
?>