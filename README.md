# A library for sharded entities management

Can be used for not only databases, but also for any sharded storage.
Implements two paradigms:
    
- virtual buckets
- hash-table for storing direct id -> shard mapping, without virtual buckets

In different cases it's more convenient to use different strategies.

## Usage:

    $configProvider = new ConfigProvider(['db_shards' => 'Resources/config/default.php']);
    
    // Virtual buckets
    $selector       = new Md5ShardSelector(); // an algorithm of a shard selection
    $collection     = CollectionFactory::create($configProvider->getConfig('db_shards'));
    $shardManager   = new ShardManager($selector, $collection);

    // get a shard by sharding key (entity id, date, etc.)
    $result = $shardManager->getByKey('any-sharding-key'); // instance of BucketResult
    $result->getShard()->getId(); // id of the selected shard
    $result->getBucket();         // id of the selected virtual bucket
    
    // ... any code needed to extract the entity from that shard
    
    

    // Stored mapping
    $persister      = new InMemoryPersister(); // stores the mapping in a simple php-array, for demo purposes
    $selector       = new PersistentRandomShardSelector($persister); // an algorithm of a shard selection
    $shardManager   = new ShardManager($selector, $collection);

    // get a shard by sharding key (entity id, date, etc.)
    $result = $shardManager->getByKey('any-sharding-key'); // instance of Result
    $result->getShard()->getId(); // id of the selected shard
    
    // ... any code needed to extract the entity from that shard