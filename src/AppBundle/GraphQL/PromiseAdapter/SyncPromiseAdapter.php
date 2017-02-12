<?php

namespace AppBundle\GraphQL\PromiseAdapter;

use Overblog\DataLoader\Promise\Adapter\Webonyx\GraphQL\SyncPromiseAdapter as BaseSyncPromiseAdapter;
use Overblog\GraphQLBundle\Executor\Promise\PromiseAdapterInterface;

class SyncPromiseAdapter extends BaseSyncPromiseAdapter implements PromiseAdapterInterface
{
}
