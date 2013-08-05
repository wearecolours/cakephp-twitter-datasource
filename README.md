# Twitter Datasource

Provides a Datasource for connecting to the Twitter API. As of now the datasource is read-only.

## Installation

To use the Twitter API you need to have an application setup. See [the app manager](https://dev.twitter.com/apps) to setup a new app or use an existing one. The Datasource uses the Consumer key and Consumer secret to authenticate with the Twitter API and requires no user login.

Lastly keep in mind the rules and guideline for using Twitter API. Read more about their policies at [Twitter API docs](https://dev.twitter.com/docs)

### 1. Get the source

Clone the project to an appropriately named plugin folder:
```
git clone git@github.com:nodesagency/cakephp-twitter-datasource.git app/Plugin/TwitterDatasource
```

Or add it as a submodule to your pre-existing git repository.
```
git submodule add git@github.com:nodesagency/cakephp-twitter-datasource.git app/Plugin/TwitterDatasource
```

### 2. Add the plugin to your project

**app/Config/bootstrap.php**
```php
CakePlugin::load('TwitterDatasource');
```

### 3. Configure the Datasource

The datasource can be configured in the database file.

**app/Config/database.php**
```php
class DATABASE_CONFIG {

	public $tweets = array(
		'datasource'    => 'TwitterDatasource.TwitterSource',
		'consumer_key'     => '', // from your Twitter app settings
		'consumer_secret' => '', // from your Twitter app settings
	);

}
```

Alternatively, it can be added to the ```ConnectionManager``` manually.

```php
App::uses('ConnectionManager', 'Model');

ConnectionManager::create('tweets', array(
	'datasource'    => 'TwitterDatasource.TwitterSource',
	'consumer_key'     => '', // from your Twitter app settings
	'consumer_secret' => '', // from your Twitter app settings
));
```

## Usage

The data source attempts to wrap the [Twitter API](https://dev.twitter.com/docs/api/1.1/) to CakePHP-style models so you can use the ```find()```, ```save()``` and ```delete()``` methods as you normally would. However, the endpoints don't handle the usual parameters (limit, order, etc) so each model acts independendtly.

### Tweet

The Tweet model is a wrapper for the given endpoints, providing access to tweets on Twitter. Calling ```find()``` on this model uses the [/search/tweets](https://dev.twitter.com/docs/api/1.1/get/search/tweets) action as default. It is possbile to access other endpoint on using ```resource``` as parameter.

#### Examples


```php
// Get tweets with a specific hashtag
$hashtag = '#hello #world';

$tweets = $this->Tweet->find(
	'all',
	array(
		'conditions' => array(
			'q' => $hashtag
		)
	)
);

// Get latest tweets of the user 'twitter'
$tweets = $this->Tweet->find(
	'all',
	array(
		'conditions' => array(
			'screen_name' => 'twitter'
		),
		'resource' => 'statuses/user_timeline'
	)
);
```

Basically you should be able to query using all of [these parameters](https://dev.twitter.com/docs/api/1.1/get/search/tweets).

### Authorization

Authorization with the Twitter API requires only a reqistered application using ```consumer_key``` and ```consumer_secret```. You need to have set up the ```consumer_key``` and ```consumer_secret``` in the database configuration (see above) and they must match the ones in your Foursquare applications manager. ```consumer_key``` and ```consumer_secret``` are submitted to the api alongside the request, authorizing it on the fly.