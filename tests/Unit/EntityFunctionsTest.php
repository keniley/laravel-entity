<?php

namespace Tests\Unit;

use Keniley\LaravelEntity\Attributes\Property;
use Keniley\LaravelEntity\Entity;
use PHPUnit\Framework\TestCase;

class EntityFunctionsTest extends TestCase
{
    /****************************************************************************/
    /*                                STRING                                    */
    /****************************************************************************/

    public function test_laod_from_source(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $entity->fromSource([
            'stringParam' => 'text',
            'intParam' => 1,
            'boolParam' => false,
        ]);

        $this->assertSame('text', $entity->stringParam);
        $this->assertSame(1, $entity->intParam);
        $this->assertObjectNotHasProperty('boolParam', $entity);
        $this->assertSame(null, $entity->boolParam);
        $this->assertArrayNotHasKey('boolParam', $entity->toArray());
    }

    public function test_fill_new(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $entity->fill([
            'stringParam' => 'text',
            'intParam' => 1,
            'boolParam' => false,
        ]);

        $this->assertSame('text', $entity->stringParam);
        $this->assertSame(1, $entity->intParam);
        $this->assertObjectNotHasProperty('boolParam', $entity);
        $this->assertSame(null, $entity->boolParam);
        $this->assertArrayNotHasKey('boolParam', $entity->toArray());
    }

    public function test_fill_after_load(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $entity->fromSource([
            'stringParam' => 'text',
            'intParam' => 1,
            'boolParam' => false,
        ]);

        $this->assertSame('text', $entity->stringParam);
        $this->assertSame(1, $entity->intParam);
        $this->assertObjectNotHasProperty('boolParam', $entity);
        $this->assertSame(null, $entity->boolParam);
        $this->assertArrayNotHasKey('boolParam', $entity->toArray());

        $entity->fill([
            'stringParam' => 'test',
            'intParam' => 10,
            'boolParam' => true,
        ]);

        $this->assertSame('test', $entity->stringParam);
        $this->assertSame(10, $entity->intParam);
        $this->assertObjectNotHasProperty('boolParam', $entity);
        $this->assertSame(null, $entity->boolParam);
        $this->assertArrayNotHasKey('boolParam', $entity->toArray());
    }

    public function test_is_new(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $this->assertSame(true, $entity->isNew());

        $entity->fill([
            'stringParam' => 'test',
            'intParam' => 10,
            'boolParam' => true,
        ]);

        $this->assertSame(true, $entity->isNew());

        $entity->stringParam = 'test2';

        $this->assertSame(true, $entity->isNew());
    }

    public function testis_new_after_load(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $this->assertSame(true, $entity->isNew());

        $entity->fromSource([
            'stringParam' => 'test',
            'intParam' => 1,
            'boolParam' => true,
        ]);

        $this->assertSame(false, $entity->isNew());

        $entity->fill([
            'stringParam' => 'test2',
            'intParam' => 10,
            'boolParam' => true,
        ]);

        $this->assertSame(false, $entity->isNew());

        $entity->stringParam = 'test3';

        $this->assertSame(false, $entity->isNew());
    }

    public function test_is_dirty(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $this->assertSame(false, $entity->isDirty());
        $this->assertSame(false, $entity->isDirty('stringParam'));
        $this->assertSame(false, $entity->isDirty('intParam'));
        $this->assertSame(false, $entity->isDirty('nonExistsParams'));

        $entity->stringParam = '';
        $this->assertSame(false, $entity->isDirty());
        $this->assertSame(false, $entity->isDirty('stringParam'));

        $entity->fill([
            'intParam' => 0,
        ]);

        $this->assertSame(false, $entity->isDirty());
        $this->assertSame(false, $entity->isDirty('intParam'));

        $entity->fill([
            'stringParam' => 'test',
        ]);

        $this->assertSame(true, $entity->isDirty());
        $this->assertSame(true, $entity->isDirty('stringParam'));
        $this->assertSame(false, $entity->isDirty('intParam'));
        $this->assertSame(false, $entity->isDirty('nonExistsParams'));

        $entity->intParam = 10;

        $this->assertSame(true, $entity->isDirty());
        $this->assertSame(true, $entity->isDirty('stringParam'));
        $this->assertSame(true, $entity->isDirty('intParam'));
    }

    public function test_is_dirty_after_load(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $this->assertSame(false, $entity->isDirty());
        $this->assertSame(false, $entity->isDirty('stringParam'));
        $this->assertSame(false, $entity->isDirty('intParam'));
        $this->assertSame(false, $entity->isDirty('nonExistsParams'));

        $entity->fromSource([
            'stringParam' => 'test',
        ]);

        $this->assertSame(false, $entity->isDirty());
        $this->assertSame(false, $entity->isDirty('stringParam'));
        $this->assertSame(false, $entity->isDirty('intParam'));
        $this->assertSame(false, $entity->isDirty('nonExistsParams'));

        $entity->fill([
            'stringParam' => 'test',
        ]);

        $this->assertSame(false, $entity->isDirty());
        $this->assertSame(false, $entity->isDirty('stringParam'));

        $entity->stringParam = 'test';
        $this->assertSame(false, $entity->isDirty());
        $this->assertSame(false, $entity->isDirty('stringParam'));

        $entity->stringParam = 'test2';
        $this->assertSame(true, $entity->isDirty());
        $this->assertSame(true, $entity->isDirty('stringParam'));

        $entity->fill([
            'intParam' => 10,
        ]);

        $this->assertSame(true, $entity->isDirty());
        $this->assertSame(true, $entity->isDirty('stringParam'));
        $this->assertSame(true, $entity->isDirty('intParam'));
    }

    public function test_get_dirty(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $this->assertSame([], $entity->getDirty()->toArray());
        $this->assertSame(null, $entity->getDirty('stringParam'));
        $this->assertSame(null, $entity->getDirty('intParam'));
        $this->assertSame(null, $entity->getDirty('nonExistsParams'));

        $entity->stringParam = '';
        $this->assertSame([], $entity->getDirty()->toArray());
        $this->assertSame(null, $entity->getDirty('stringParam'));

        $entity->fill([
            'intParam' => 0,
        ]);

        $this->assertSame([], $entity->getDirty()->toArray());
        $this->assertSame(null, $entity->getDirty('intParam'));

        $entity->fill([
            'stringParam' => 'test',
        ]);

        $this->assertArrayHasKey('stringParam', $entity->getDirty());
        $this->assertSame('test', $entity->getDirty('stringParam'));

        $entity->intParam = 10;

        $this->assertArrayHasKey('intParam', $entity->getDirty());
        $this->assertSame(10, $entity->getDirty('intParam'));
    }

    public function test_get_dirty_after_load(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $this->assertSame([], $entity->getDirty()->toArray());
        $this->assertSame(null, $entity->getDirty('stringParam'));
        $this->assertSame(null, $entity->getDirty('intParam'));
        $this->assertSame(null, $entity->getDirty('nonExistsParams'));

        $entity->fromSource([
            'stringParam' => 'test',
        ]);

        $this->assertSame([], $entity->getDirty()->toArray());
        $this->assertSame(null, $entity->getDirty('stringParam'));

        $entity->fill([
            'stringParam' => 'test2',
        ]);

        $this->assertArrayHasKey('stringParam', $entity->getDirty());
        $this->assertSame('test2', $entity->getDirty('stringParam'));
    }

    public function test_values(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $stringParam;

            #[Property(cast: 'int')]
            protected int $intParam;
        };

        $this->assertArrayHasKey('stringParam', $entity->values());
        $this->assertArrayHasKey('intParam', $entity->values());

        $entity->fromSource([
            'stringParam' => 'text',
            'intParam' => 1,
            'boolParam' => false,
        ]);

        $this->assertArrayHasKey('stringParam', $entity->values());
        $this->assertArrayHasKey('intParam', $entity->values());
        $this->assertArrayNotHasKey('boolParam', $entity->values());
    }

    // test repository
    // test collection
    // test observer
    // test fire event
}
