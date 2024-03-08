<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use Keniley\LaravelEntity\Attributes\Property;
use Keniley\LaravelEntity\Casts\JsonToArrayCast;
use Keniley\LaravelEntity\Casts\JsonToCollectionCast;
use Keniley\LaravelEntity\Casts\JsonToObjectCast;
use Keniley\LaravelEntity\Entity;
use PHPUnit\Framework\TestCase;

class EntityJsonCastTest extends TestCase
{
    public function test_cast_json_to_array(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: JsonToArrayCast::class, default: [])]
            protected array $param;
        };

        $entity->param = json_encode(['run' => 'test']);

        $this->assertIsArray($entity->param);
        $this->assertArrayHasKey('run', $entity->param);
        $this->assertSame('test', $entity->param['run']);

        $entity->param = ['run' => 'test2'];

        $this->assertIsArray($entity->param);
        $this->assertArrayHasKey('run', $entity->param);
        $this->assertSame('test2', $entity->param['run']);

        // not valid json = $default
        $entity->param = 'run';

        $this->assertIsArray($entity->param);
        $this->assertSame([], $entity->param);

        // not valid string = $default
        $entity->param = true;

        $this->assertIsArray($entity->param);
        $this->assertSame([], $entity->param);

    }

    public function test_cast_json_to_object(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: JsonToObjectCast::class, default: new \stdClass())]
            protected object $param;
        };

        $entity->param = json_encode(['run' => 'test']);

        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('run', $entity->param);
        $this->assertSame('test', $entity->param->run);

        $teststd = new \stdClass();
        $teststd->run = 'test2';

        $entity->param = $teststd;

        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('run', $entity->param);
        $this->assertSame('test2', $entity->param->run);

        // not valid json = $default
        $entity->param = 'run';

        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertSame([], get_object_vars($entity->param));

        // not valid string = $default
        $entity->param = true;

        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertSame([], get_object_vars($entity->param));
    }

    public function test_cast_json_to_collection(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: JsonToCollectionCast::class, default: new Collection())]
            protected Collection $param;
        };

        $entity->param = json_encode(['run' => 'test']);

        $this->assertInstanceOf(Collection::class, $entity->param);
        $this->assertSame('test', $entity->param->get('run'));

        $teststd = collect([1, 2, 3]);
        $entity->param = $teststd;

        $this->assertInstanceOf(Collection::class, $entity->param);
        $this->assertSame(1, $entity->param->first());

        // not valid json = $default
        $entity->param = 'run';

        $this->assertInstanceOf(Collection::class, $entity->param);
        $this->assertSame([], $entity->param->toArray());

        // not valid string = $default
        $entity->param = true;

        $this->assertInstanceOf(Collection::class, $entity->param);
        $this->assertSame([], $entity->param->toArray());
    }
}
