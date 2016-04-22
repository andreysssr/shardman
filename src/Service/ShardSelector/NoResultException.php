<?php


namespace Shardman\Service\ShardSelector;


class NoResultException extends \Exception
{
    protected $message = 'No bucket found';
}