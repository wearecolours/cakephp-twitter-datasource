<?php
App::uses('DataSource', 'Model/Datasource');
App::uses('MockTwitterSource', 'TwitterDatasource.Model/Datasource');
App::uses('TwitterSource', 'TwitterDatasource.Model/Datasource');
App::uses('Tweet', 'TwitterDatasource.Model');

class MockTwitterSource extends TwitterSource {

	/**
	 * reset access token to disable the "authentication - cache"
	 * @return void
	 */
	public function resetAccessToken() {
		$this->_accessToken = null;
	}

	/**
	 * making auth accessable for the test
	 * @return void
	 */
	public function auth() {
		return parent::_auth();
	}

	/**
	 * override default _curl method to mock results
	 * @param  string  $url
	 * @param  string  $type
	 * @param  array   $params
	 * @param  boolean $authentication
	 * @return array
	 */
	public function _curl($url, $type = 'GET', $params = array(), $authentication = false) {
		switch ($url) {
			// authentication
			case "https://api.twitter.com/oauth2/token/":
				if ($authentication == 'Basic Zm9vOmJhcg==') {
					// correct authentication
					$data = (object) array(
						'access_token' => 'AAAAAAAAAAAAAAAAAAAAAHLYSAAAAAAASkA90S9OLGpKKcBbEraJY5M9ATs%3DuRLV72q5deaUhfAKQc4NAskkENkiU4PEBqmD7DWiw',
						'token_type' => 'bearer'
					);
				} else {
					// authentication failed
					$data = (object) array(
						'errors' => array(
							(object) array(
								'label' => 'authenticity_token_error',
								'code' => 99,
								'message' => 'Unable to verify your credentials'
							)
						)
					);
				}
				break;
			case "https://api.twitter.com/1.1/search/tweets.json?q=%23hello+%23world":
			case "https://api.twitter.com/1.1/search/tweets.json?q=%23hello+%23world&locale=en&count=10":
			case "https://api.twitter.com/1.1/search/tweets.json?q=%23hello%20%23world&locale=en&count=10":
				$data = $this->_searchResults(10);
				break;
			case "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=twitterapi&count=5":
				$data = $this->_userTimelineResults(5);
				break;
			default:
				// call parent object
				$data = parent::_curl($url, $type, $params, $authentication);
		}
		return $data;
	}

	protected function _searchResults($amount = 1) {
		$result = array();
		$data = (object) array(
			'metadata' => (object) array(
				'result_type' => 'recent',
				'iso_language_code' => 'en'
			),
			'created_at' => 'Tue Jul 23 13:08:51 +0000 2013',
			'id' => 359661385078149120,
			'id_str' => '359661385078149120',
			'text' => 'S/O to Middle Georgia State College mgscconnect !! #Good Morning . #Hello #MGSC #MGSC #MaconCampus… http://t.co/HQMf41XaN2',
			'source' => '<a href="http://instagram.com" rel="nofollow">Instagram</a>',
			'truncated' => false,
			'in_reply_to_status_id' => null,
			'in_reply_to_status_id_str' => null,
			'in_reply_to_user_id' => null,
			'in_reply_to_user_id_str' => null,
			'in_reply_to_screen_name' => null,
			'user' => (object) array(
				'id' => 276086144,
				'id_str' => '276086144',
				'name' => 'TiffaniCeleste',
				'screen_name' => 'PoeticVoice_',
				'location' => 'WithMarilynMonroe',
				'description' => 'MLK Alumni. Middle Georgia State Sophmore. Business Major. Church Girl. Bright Future Ahead. Inspiring Writer & Motivational Speaker. #MGSC ❤',
				'url' => 'http://t.co/jD2dbzN0EH',
				'entities' => (object) array(
					'url' => (object) array(
						'urls' => array(
							'0' => (object) array(
								'url' => 'http://t.co/jD2dbzN0EH',
								'expanded_url' => 'http://www.tiffanivicks.com',
								'display_url' => 'tiffanivicks.com',
								'indices' => array(
									'0' => 0,
									'1' => 22
								)
							)
						)
					),
					'description' => (object) array(
						'urls' => array()
					)
				),
				'protected' => false,
				'followers_count' => 944,
				'friends_count' => 1019,
				'listed_count' => 14,
				'created_at' => 'Sat Apr 02 16:30:24 +0000 2011',
				'favourites_count' => 2381,
				'utc_offset' => -18000,
				'time_zone' => 'Quito',
				'geo_enabled' => true,
				'verified' => false,
				'statuses_count' => 31556,
				'lang' => 'en',
				'contributors_enabled' => false,
				'is_translator' => false,
				'profile_background_color' => 'B2DFDA',
				'profile_background_image_url' => 'http://a0.twimg.com/profile_background_images/378800000019618464/c38f843973b5687d540c031ff0f3a848.jpeg',
				'profile_background_image_url_https' => 'https://si0.twimg.com/profile_background_images/378800000019618464/c38f843973b5687d540c031ff0f3a848.jpeg',
				'profile_background_tile' => true,
				'profile_image_url' => 'http://a0.twimg.com/profile_images/378800000082958247/ee2a7bd075e6b72626ab7f26cd3e4a5f_normal.jpeg',
				'profile_image_url_https' => 'https://si0.twimg.com/profile_images/378800000082958247/ee2a7bd075e6b72626ab7f26cd3e4a5f_normal.jpeg',
				'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/276086144/1360617187',
				'profile_link_color' => '2CDBBE',
				'profile_sidebar_border_color' => 'FFFFFF',
				'profile_sidebar_fill_color' => 'FFFFFF',
				'profile_text_color' => 'FC0015',
				'profile_use_background_image' => true,
				'default_profile' => false,
				'default_profile_image' => false,
				'following' => null,
				'follow_request_sent' => null,
				'notifications' => null
			),
			'geo' => null,
			'coordinates' => null,
			'place' => null,
			'contributors' => null,
			'retweet_count' => 0,
			'favorite_count' => 0,
			'entities' => (object) array(
				'hashtags' => array(
					'0' => (object) array(
						'text' => 'Good',
						'indices' => array(
							'0' => 51,
							'1' => 56
						)
					),
					'1' => (object) array(
						'text' => 'Hello',
						'indices' => array(
							'0' => 67,
							'1' => 73
						)
					),
					'2' => (object) array(
						'text' => 'MGSC',
						'indices' => array(
							'0' => 74,
							'1' => 79
						)
					),
					'3' => (object) array(
						'text' => 'MGSC',
						'indices' => array(
							'0' => 80,
							'1' => 85
						)
					),
					'4' => (object) array(
						'text' => 'MaconCampus',
						'indices' => array(
							'0' => 86,
							'1' => 98
						)
					)
				),
				'symbols' => array(),
				'urls' => array(
					'0' => (object) array(
						'url' => 'http://t.co/HQMf41XaN2',
						'expanded_url' => 'http://instagram.com/p/cHAuXPyG-w/',
						'display_url' => 'instagram.com/p/cHAuXPyG-w/',
						'indices' => array(
							'0' => 100,
							'1' => 122
						)
					)
				),
				'user_mentions' => array()
			),
			'favorited' => false,
			'retweeted' => false,
			'possibly_sensitive' => false,
			'lang' => 'en'
		);
		for ($i=0; $i < $amount; $i++) {
			$result[$i] = clone $data;
			$result[$i]->id = $i;
		}

		// rebuild result set
		$result = (object) array(
			'statuses' => $result,
			'search_metadata' => (object) array(
				'completed_in' => 0.033,
				'max_id' => 359661385078149120,
				'max_id_str' => '359661385078149120',
				'next_results' => '?max_id=359713967817506816&q=%23hello%20%23world&count=10&include_entities=1',
				'query' => '%23hello+%23world',
				'refresh_url' => '?since_id=359937952811466752&q=%23hello%20%23world&include_entities=1',
				'count' => $amount,
				'since_id' => 0,
				'since_id_str' => '0'
			)
		);
		return $result;
	}

	protected function _userTimelineResults($amount = 1) {
		$result = array();

		$data = (object) array(
			'created_at' => 'Mon Jul 08 22:34:49 +0000 2013',
			'id' => 354367997139361792,
			'id_str' => '354367997139361792',
			'text' => 'We have updated our Player Cards guidelines. Quick overview and discussion in our developer forums: https://t.co/wt5oLZROQ6.',
			'source' => 'web',
			'truncated' => false,
			'in_reply_to_status_id' => null,
			'in_reply_to_status_id_str' => null,
			'in_reply_to_user_id' => null,
			'in_reply_to_user_id_str' => null,
			'in_reply_to_screen_name' => null,
			'user' => (object) array(
				'id' => 6253282,
				'id_str' => '6253282',
				'name' => 'Twitter API',
				'screen_name' => 'twitterapi',
				'location' => 'San Francisco, CA',
				'description' => 'The Real Twitter API. I tweet about API changes, service issues and happily answer questions about Twitter and our API. Don\'t get an answer? It\'s on my website.',
				'url' => 'http://t.co/78pYTvWfJd',
				'entities' => (object) array(
					'url' => (object) array(
						'urls' => array(
							'0' => (object) array(
								'url' => 'http://t.co/78pYTvWfJd',
								'expanded_url' => 'http://dev.twitter.com',
								'display_url' => 'dev.twitter.com',
								'indices' => array(
									'0' => 0,
									'1' => 22
								)
							)
						)
					),
					'description' => (object) array(
						'urls' => array()
					)
				),
				'protected' => false,
				'followers_count' => 1757407,
				'friends_count' => 34,
				'listed_count' => 11853,
				'created_at' => 'Wed May 23 06:01:13 +0000 2007',
				'favourites_count' => 25,
				'utc_offset' => -25200,
				'time_zone' => 'Pacific Time (US & Canada)',
				'geo_enabled' => true,
				'verified' => true,
				'statuses_count' => 3441,
				'lang' => 'en',
				'contributors_enabled' => false,
				'is_translator' => false,
				'profile_background_color' => 'C0DEED',
				'profile_background_image_url' => 'http://a0.twimg.com/profile_background_images/656927849/miyt9dpjz77sc0w3d4vj.png',
				'profile_background_image_url_https' => 'https://si0.twimg.com/profile_background_images/656927849/miyt9dpjz77sc0w3d4vj.png',
				'profile_background_tile' => true,
				'profile_image_url' => 'http://a0.twimg.com/profile_images/2284174872/7df3h38zabcvjylnyfe3_normal.png',
				'profile_image_url_https' => 'https://si0.twimg.com/profile_images/2284174872/7df3h38zabcvjylnyfe3_normal.png',
				'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/6253282/1347394302',
				'profile_link_color' => '0084B4',
				'profile_sidebar_border_color' => 'C0DEED',
				'profile_sidebar_fill_color' => 'DDEEF6',
				'profile_text_color' => '333333',
				'profile_use_background_image' => true,
				'default_profile' => false,
				'default_profile_image' => false,
				'following' => null,
				'follow_request_sent' => null,
				'notifications' => null,
			),
			'geo' => null,
			'coordinates' => null,
			'place' => null,
			'contributors' => null,
			'retweet_count' => 127,
			'favorite_count' => 43,
			'entities' => (object) array(
				'hashtags' => array(),
				'symbols' => array(),
				'urls' => array(
					'0' => (object) array(
						'url' => 'https://t.co/wt5oLZROQ6',
						'expanded_url' => 'https://dev.twitter.com/discussions/19492',
						'display_url' => 'dev.twitter.com/discussions/19…',
						'indices' => array(
							'0' => 100,
							'1' => 123
						)
					)
				),
				'user_mentions' => array()
			),
			'favorited' => false,
			'retweeted' => false,
			'possibly_sensitive' => false,
			'lang' => 'en'
		);


		for ($i=0; $i < $amount; $i++) {
			$result[$i] = clone $data;
			$result[$i]->id = $i;
		}
		return $result;
	}
}

/**
 * TwitterSourceTestCase
 */
class TwitterSourceTestCase extends CakeTestCase {

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		// My test client; please don't abuse
		ConnectionManager::create('twitter_test', array(
			'datasource' => 'TwitterDatasource.MockTwitterSource',
			'consumer_key' => 'foo', // from your Twitter app settings
			'consumer_secret' => 'bar', // from your Twitter app settings
		));
	}

	public function setUp() {
		parent::setUp();
		$this->TwitterSource = ConnectionManager::getDataSource('twitter_test');
		$this->Tweet = ClassRegistry::init('TwitterDatasource.Tweet');
	}

	public function tearDown() {
		unset($this->TwitterSource);
		unset($this->Tweet);
		parent::tearDown();
	}

	public function testReadWithNotSupportedModel() {
		$this->expectException('Exception');
		$item = $this->TwitterSource->read($this->TwitterSource);
	}

	public function testReadSearchTweets() {
		$item = $this->TwitterSource->read($this->Tweet, array(
			'conditions' => array(
				'q' => '#hello #world',
				'locale' => 'en',
				'count' => 10
			)
		));
		$this->assertEqual(count($item), 10, 'It should only have ten item');
		$this->assertNotNull($item[0]['Tweet']['id']);
	}

	public function testReadStatusesUserTimeline() {
		$item = $this->TwitterSource->read($this->Tweet, array(
			'conditions' => array(
				'screen_name' => 'twitterapi',
				'count' => 5
			),
			'resource' => 'statuses/user_timeline'
		));
		$this->assertEqual(count($item), 5, 'It should only have five item');
		$this->assertEqual($item[0]['Tweet']['id'], '0');
		$this->assertEqual($item[4]['Tweet']['id'], '4');
	}

	public function testReadWithLimit() {
		$item = $this->TwitterSource->read($this->Tweet, array(
			'conditions' => array(
				'q' => '#hello #world'
			),
			'limit' => 2
		));
		$this->assertEqual(count($item), 2, 'It should only have two item');
		$this->assertEqual($item[0]['Tweet']['id'], 0);
		$this->assertEqual($item[1]['Tweet']['id'], 1);
	}

	public function testReadWithOffset() {
		$item = $this->TwitterSource->read($this->Tweet, array(
			'conditions' => array(
				'q' => '#hello #world'
			),
			'limit' => 1,
			'offset' => 4
		));
		$this->assertEqual(count($item), 1, 'It should only have one item');
		$this->assertEqual($item[0]['Tweet']['id'], 4);
	}

	public function testCreate() {
		$this->expectException('Exception');
		$this->TwitterSource->create($this->Tweet);
	}

	public function testDelete() {
		$this->expectException('Exception');
		$this->TwitterSource->delete($this->Tweet);
	}

	public function testUpdate() {
		$this->expectException('Exception');
		$this->TwitterSource->update($this->Tweet);
	}

	public function testListSources() {
		$this->assertNull($this->TwitterSource->listSources());
	}

	public function testAuthenticate() {
		$this->assertNotEmpty($this->TwitterSource->auth());
	}

	public function testAuthenticateFailsWithWrongCredentials() {
		$this->expectException('Exception');
		$this->TwitterSource->resetAccessToken();
		$this->TwitterSource->config['consumer_secret'] = 'foo';
		$this->TwitterSource->auth();
	}
}