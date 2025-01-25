<?php
class NY_Surf_Conditions_API extends WP_REST_Controller {
    private $api_key;
    private $cache_time = 86400; // 24 hours in seconds

    public function __construct() {
        $this->namespace = 'surf-app/v1';
        $this->rest_base = 'conditions';
        
        // Determine environment and set appropriate API key
        $environment = wp_get_environment_type(); // or define your own way to detect environment
        
        if ($environment === 'production' || strpos($_SERVER['HTTP_HOST'], 'wpjon.info') !== false) {
            $this->api_key = 'a82f4f36-d2a7-11ef-acf2-0242ac130003-a82f4fae-d2a7-11ef-acf2-0242ac130003';
        } else {
            $this->api_key = '67cb6906-d357-11ef-9159-0242ac130003-67cb6a0a-d357-11ef-9159-0242ac130003';
        }
        
        // Debug logging
        error_log('=== NY Surf Conditions API Initialized ===');
        error_log('Environment: ' . $environment);
        error_log('Host: ' . $_SERVER['HTTP_HOST']);
        error_log('API Key Status: ' . (empty($this->api_key) ? 'Missing' : 'Present'));
        error_log('Namespace: ' . $this->namespace);
        error_log('Rest Base: ' . $this->rest_base);
    }

    public function register_routes() {
        error_log('Registering surf conditions routes');
        
        register_rest_route($this->namespace, '/' . $this->rest_base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_conditions'],
                'permission_callback' => '__return_true'
            ]
        ]);
    }

    public function get_conditions($request) {
        error_log('=== Processing Surf Conditions Request ===');
        
        try {
            $lat = $request->get_param('lat');
            $lng = $request->get_param('lng');
            
            error_log("Request parameters - lat: $lat, lng: $lng");
            
            if (!$lat || !$lng) {
                throw new Exception('Missing latitude or longitude parameters');
            }

            if (empty($this->api_key)) {
                error_log('StormGlass API key is missing');
                throw new Exception('API key not configured');
            }
            
            // Create cache key
            $cache_key = "surf_conditions_{$lat}_{$lng}";
            
            // Check cache
            $cached_data = get_transient($cache_key);
            if ($cached_data !== false) {
                error_log('Returning cached data');
                return new WP_REST_Response(json_decode($cached_data), 200);
            }

            $endpoint = "https://api.stormglass.io/v2/weather/point";
            $params = [
                'lat' => $lat,
                'lng' => $lng,
                'params' => 'waveHeight,swellHeight,windWaveHeight,waveDirection,wavePeriod,windSpeed,windDirection,waterTemperature',
                'source' => 'noaa'
            ];

            $url = add_query_arg($params, $endpoint);
            error_log("Making StormGlass API request to: $url");

            $response = wp_remote_get($url, [
                'headers' => [
                    'Authorization' => $this->api_key
                ],
                'timeout' => 15
            ]);

            if (is_wp_error($response)) {
                error_log('WP Remote Get Error: ' . $response->get_error_message());
                throw new Exception($response->get_error_message());
            }

            $status = wp_remote_retrieve_response_code($response);
            $body = wp_remote_retrieve_body($response);
            
            error_log("StormGlass API Response - Status: $status");
            error_log("Response Body: " . substr($body, 0, 500) . '...'); // Log first 500 chars

            if ($status !== 200) {
                throw new Exception("StormGlass API returned status $status: $body");
            }

            // Cache the response
            set_transient($cache_key, $body, $this->cache_time);
            
            return new WP_REST_Response(json_decode($body), 200);

        } catch (Exception $e) {
            error_log('Surf conditions API error: ' . $e->getMessage());
            return new WP_Error(
                'api_error',
                $e->getMessage(),
                ['status' => 500]
            );
        }
    }
}