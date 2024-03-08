<?php

namespace Tests\Unit;

use Keniley\LaravelEntity\Attributes\Property;
use Keniley\LaravelEntity\Entity;
use PHPUnit\Framework\TestCase;

class EntityBuildInTypesTest extends TestCase
{
    /****************************************************************************/
    /*                                STRING                                    */
    /****************************************************************************/

    public function test_entity_cast_buildin_type_string(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string')]
            protected string $param;
        };

        $this->assertSame('', $entity->param);
        $entity->param = 1;
        $this->assertSame('1', $entity->param);
        $entity->param = true;
        $this->assertSame('1', $entity->param);
        $entity->param = false;
        $this->assertSame('', $entity->param);
    }

    public function test_entity_cast_buildin_type_string_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected string $param;
        };

        $this->assertSame('', $entity->param);
        $entity->param = 1;
        $this->assertSame('1', $entity->param);
        $entity->param = true;
        $this->assertSame('1', $entity->param);
        $entity->param = false;
        $this->assertSame('', $entity->param);
    }

    public function test_entity_cast_buildin_type_string_with_default_null(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string', default: null)]
            protected ?string $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame('1', $entity->param);
        $entity->param = true;
        $this->assertSame('1', $entity->param);
        $entity->param = false;
        $this->assertSame(null, $entity->param);
    }

    public function test_entity_cast_buildin_type_string_nullable_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected ?string $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame('1', $entity->param);
        $entity->param = true;
        $this->assertSame('1', $entity->param);
        $entity->param = false;
        $this->assertSame(null, $entity->param);
    }

    public function test_entity_cast_buildin_type_string_with_default_text(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string', default: 'text')]
            protected string $param;
        };

        $this->assertSame('text', $entity->param);
        $entity->param = 1;
        $this->assertSame('1', $entity->param);
        $entity->param = true;
        $this->assertSame('1', $entity->param);
        $entity->param = false;
        $this->assertSame('text', $entity->param);
    }

    public function test_entity_cast_buildin_type_string_nullable_with_default_text(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string', default: 'text')]
            protected ?string $param;
        };

        $this->assertSame('text', $entity->param);
        $entity->param = 1;
        $this->assertSame('1', $entity->param);
        $entity->param = true;
        $this->assertSame('1', $entity->param);
        $entity->param = false;
        $this->assertSame('text', $entity->param);
    }

    public function test_entity_cast_buildin_type_string_nullable_with_default_wrong_default_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'string', default: 10)]
            protected string $param;
        };
    }

    public function test_entity_cast_buildin_type_string_with_wrong_cast_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'bool')]
            protected string $param;
        };
    }

    /****************************************************************************/
    /*                                 INT                                      */
    /****************************************************************************/

    public function test_entity_cast_buildin_type_int(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'int')]
            protected int $param;
        };

        $this->assertSame(0, $entity->param);
        $entity->param = 1;
        $this->assertSame(1, $entity->param);
        $entity->param = true;
        $this->assertSame(1, $entity->param);
        $entity->param = false;
        $this->assertSame(0, $entity->param);
        $entity->param = '1';
        $this->assertSame(1, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(0, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1, $entity->param);
    }

    public function test_entity_cast_buildin_type_int_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected int $param;
        };

        $this->assertSame(0, $entity->param);
        $entity->param = 1;
        $this->assertSame(1, $entity->param);
        $entity->param = true;
        $this->assertSame(1, $entity->param);
        $entity->param = false;
        $this->assertSame(0, $entity->param);
        $entity->param = '1';
        $this->assertSame(1, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(0, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1, $entity->param);
    }

    public function test_entity_cast_buildin_type_int_with_default_null(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'int', default: null)]
            protected ?int $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame(1, $entity->param);
        $entity->param = true;
        $this->assertSame(1, $entity->param);
        $entity->param = false;
        $this->assertSame(null, $entity->param);
        $entity->param = '1';
        $this->assertSame(1, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(null, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1, $entity->param);
    }

    public function test_entity_cast_buildin_type_int_nullable_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected ?int $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame(1, $entity->param);
        $entity->param = true;
        $this->assertSame(1, $entity->param);
        $entity->param = false;
        $this->assertSame(null, $entity->param);
        $entity->param = '1';
        $this->assertSame(1, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(null, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1, $entity->param);
    }

    public function test_entity_cast_buildin_type_int_with_default_int(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'int', default: 10)]
            protected int $param;
        };

        $this->assertSame(10, $entity->param);
        $entity->param = 1;
        $this->assertSame(1, $entity->param);
        $entity->param = true;
        $this->assertSame(1, $entity->param);
        $entity->param = false;
        $this->assertSame(10, $entity->param);
        $entity->param = '1';
        $this->assertSame(1, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(10, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1, $entity->param);
    }

    public function test_entity_cast_buildin_type_int_nullable_with_default_int(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'int', default: 10)]
            protected ?int $param;
        };

        $this->assertSame(10, $entity->param);
        $entity->param = 1;
        $this->assertSame(1, $entity->param);
        $entity->param = true;
        $this->assertSame(1, $entity->param);
        $entity->param = false;
        $this->assertSame(10, $entity->param);
        $entity->param = '1';
        $this->assertSame(1, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(10, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1, $entity->param);
    }

    public function test_entity_cast_buildin_type_int_with_default_wrong_default_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'int', default: 'text')]
            protected int $param;
        };
    }

    public function test_entity_cast_buildin_type_int_with_wrong_cast_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'string')]
            protected int $param;
        };
    }

    /****************************************************************************/
    /*                                 BOOL                                     */
    /****************************************************************************/

    public function test_entity_cast_buildin_type_bool(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'bool')]
            protected bool $param;
        };

        $this->assertSame(false, $entity->param);
        $entity->param = 1;
        $this->assertSame(true, $entity->param);
        $entity->param = true;
        $this->assertSame(true, $entity->param);
        $entity->param = false;
        $this->assertSame(false, $entity->param);
        $entity->param = '1';
        $this->assertSame(true, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(true, $entity->param);
        $entity->param = '0';
        $this->assertSame(false, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(true, $entity->param);
    }

    public function test_entity_cast_buildin_type_bool_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected bool $param;
        };

        $this->assertSame(false, $entity->param);
        $entity->param = 1;
        $this->assertSame(true, $entity->param);
        $entity->param = true;
        $this->assertSame(true, $entity->param);
        $entity->param = false;
        $this->assertSame(false, $entity->param);
        $entity->param = '1';
        $this->assertSame(true, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(true, $entity->param);
        $entity->param = '0';
        $this->assertSame(false, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(true, $entity->param);
    }

    public function test_entity_cast_buildin_type_bool_with_default_null(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'bool', default: null)]
            protected ?bool $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame(true, $entity->param);
        $entity->param = true;
        $this->assertSame(true, $entity->param);
        $entity->param = false;
        $this->assertSame(false, $entity->param);
        $entity->param = '1';
        $this->assertSame(true, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(true, $entity->param);
        $entity->param = '0';
        $this->assertSame(false, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(true, $entity->param);
    }

    public function test_entity_cast_buildin_type_bool_nullable_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected ?bool $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame(true, $entity->param);
        $entity->param = true;
        $this->assertSame(true, $entity->param);
        $entity->param = false;
        $this->assertSame(false, $entity->param);
        $entity->param = '1';
        $this->assertSame(true, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(true, $entity->param);
        $entity->param = '0';
        $this->assertSame(false, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(true, $entity->param);
    }

    public function test_entity_cast_buildin_type_bool_with_default_bool(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'bool', default: true)]
            protected ?bool $param;
        };

        $this->assertSame(true, $entity->param);
        $entity->param = 1;
        $this->assertSame(true, $entity->param);
        $entity->param = true;
        $this->assertSame(true, $entity->param);
        $entity->param = false;
        $this->assertSame(false, $entity->param);
        $entity->param = '1';
        $this->assertSame(true, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(true, $entity->param);
        $entity->param = '0';
        $this->assertSame(false, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(true, $entity->param);
    }

    public function test_entity_cast_buildin_type_bool_with_default_wrong_default_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'bool', default: 'text')]
            protected bool $param;
        };
    }

    public function test_entity_cast_buildin_type_bool_with_wrong_cast_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'int')]
            protected bool $param;
        };
    }

    /****************************************************************************/
    /*                                 FLOAT                                    */
    /****************************************************************************/

    public function test_entity_cast_buildin_type_float(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'float')]
            protected float $param;
        };

        $this->assertSame(0.0, $entity->param);
        $entity->param = 1;
        $this->assertSame(1.0, $entity->param);
        $entity->param = true;
        $this->assertSame(1.0, $entity->param);
        $entity->param = false;
        $this->assertSame(0.0, $entity->param);
        $entity->param = '1';
        $this->assertSame(1.0, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(0.0, $entity->param);
        $entity->param = '0';
        $this->assertSame(0.0, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1.2, $entity->param);
    }

    public function test_entity_cast_buildin_type_float_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected float $param;
        };

        $this->assertSame(0.0, $entity->param);
        $entity->param = 1;
        $this->assertSame(1.0, $entity->param);
        $entity->param = true;
        $this->assertSame(1.0, $entity->param);
        $entity->param = false;
        $this->assertSame(0.0, $entity->param);
        $entity->param = '1';
        $this->assertSame(1.0, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(0.0, $entity->param);
        $entity->param = '0';
        $this->assertSame(0.0, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1.2, $entity->param);
    }

    public function test_entity_cast_buildin_type_float_with_default_null(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'float', default: null)]
            protected ?float $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame(1.0, $entity->param);
        $entity->param = true;
        $this->assertSame(1.0, $entity->param);
        $entity->param = false;
        $this->assertSame(0.0, $entity->param);
        $entity->param = '1';
        $this->assertSame(1.0, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(0.0, $entity->param);
        $entity->param = '0';
        $this->assertSame(0.0, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1.2, $entity->param);
    }

    public function test_entity_cast_buildin_type_float_nullable_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected ?float $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame(1.0, $entity->param);
        $entity->param = true;
        $this->assertSame(1.0, $entity->param);
        $entity->param = false;
        $this->assertSame(0.0, $entity->param);
        $entity->param = '1';
        $this->assertSame(1.0, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(0.0, $entity->param);
        $entity->param = '0';
        $this->assertSame(0.0, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1.2, $entity->param);
    }

    public function test_entity_cast_buildin_type_float_with_default_float(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'float', default: 1.3)]
            protected float $param;
        };

        $this->assertSame(1.3, $entity->param);
        $entity->param = 1;
        $this->assertSame(1.0, $entity->param);
        $entity->param = true;
        $this->assertSame(1.0, $entity->param);
        $entity->param = false;
        $this->assertSame(0.0, $entity->param);
        $entity->param = '1';
        $this->assertSame(1.0, $entity->param);
        $entity->param = 'neco';
        $this->assertSame(0.0, $entity->param);
        $entity->param = '0';
        $this->assertSame(0.0, $entity->param);
        $entity->param = 1.2;
        $this->assertSame(1.2, $entity->param);
    }

    public function test_entity_cast_buildin_type_float_with_default_int(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'float', default: 8)]
            protected float $param;
        };
    }

    public function test_entity_cast_buildin_type_float_with_wrong_default_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'float', default: 'test')]
            protected float $param;
        };
    }

    public function test_entity_cast_buildin_type_float_with_wrong_cast_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'bool')]
            protected float $param;
        };
    }

    /****************************************************************************/
    /*                                 ARRAY                                    */
    /****************************************************************************/

    public function test_entity_cast_buildin_type_array(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'array')]
            protected array $param;
        };

        $this->assertSame([], $entity->param);
        $entity->param = 1;
        $this->assertSame([1], $entity->param);
        $entity->param = true;
        $this->assertSame([true], $entity->param);
        $entity->param = false;
        $this->assertSame([false], $entity->param);
        $entity->param = ['test'];
        $this->assertSame(['test'], $entity->param);
        $entity->param = [];
        $this->assertSame([], $entity->param);
    }

    public function test_entity_cast_buildin_type_array_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected array $param;
        };

        $this->assertSame([], $entity->param);
        $entity->param = 1;
        $this->assertSame([1], $entity->param);
        $entity->param = true;
        $this->assertSame([true], $entity->param);
        $entity->param = false;
        $this->assertSame([false], $entity->param);
        $entity->param = ['test'];
        $this->assertSame(['test'], $entity->param);
        $entity->param = [];
        $this->assertSame([], $entity->param);
    }

    public function test_entity_cast_buildin_type_array_with_default_null(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'array', default: null)]
            protected ?array $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame([1], $entity->param);
        $entity->param = true;
        $this->assertSame([true], $entity->param);
        $entity->param = false;
        $this->assertSame([false], $entity->param);
        $entity->param = ['test'];
        $this->assertSame(['test'], $entity->param);
        $entity->param = [];
        $this->assertSame(null, $entity->param);
    }

    public function test_entity_cast_buildin_type_array_nullable_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected ?array $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertSame([1], $entity->param);
        $entity->param = true;
        $this->assertSame([true], $entity->param);
        $entity->param = false;
        $this->assertSame([false], $entity->param);
        $entity->param = ['test'];
        $this->assertSame(['test'], $entity->param);
        $entity->param = [];
        $this->assertSame(null, $entity->param);
    }

    public function test_entity_cast_buildin_type_array_with_default_array(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'array', default: ['text'])]
            protected ?array $param;
        };

        $this->assertSame(['text'], $entity->param);
        $entity->param = 1;
        $this->assertSame([1], $entity->param);
        $entity->param = true;
        $this->assertSame([true], $entity->param);
        $entity->param = false;
        $this->assertSame([false], $entity->param);
        $entity->param = ['test'];
        $this->assertSame(['test'], $entity->param);
        $entity->param = [];
        $this->assertSame(['text'], $entity->param);
    }

    public function test_entity_cast_buildin_type_array_with_wrong_default_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'array', default: 'text')]
            protected ?array $param;
        };
    }

    public function test_entity_cast_buildin_type_array_with_wrong_cast_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'int')]
            protected array $param;
        };
    }

    /****************************************************************************/
    /*                                 OBJECT                                   */
    /****************************************************************************/

    public function test_entity_cast_buildin_type_object(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'object')]
            protected object $param;
        };

        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $entity->param = 1;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(1, $entity->param->scalar);
        $entity->param = true;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(true, $entity->param->scalar);
        $entity->param = false;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(false, $entity->param->scalar);
        $entity->param = ['prop' => 'test'];
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('prop', $entity->param);
        $this->assertSame('test', $entity->param->prop);
        $entity->param = 'test';
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame('test', $entity->param->scalar);
        $entity->param = null;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectNotHasProperty('scalar', $entity->param);
        $entity->param = new \DateTime('now');
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectNotHasProperty('scalar', $entity->param);
    }

    public function test_entity_cast_buildin_type_object_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected object $param;
        };

        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $entity->param = 1;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(1, $entity->param->scalar);
        $entity->param = true;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(true, $entity->param->scalar);
        $entity->param = false;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(false, $entity->param->scalar);
        $entity->param = ['prop' => 'test'];
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('prop', $entity->param);
        $this->assertSame('test', $entity->param->prop);
        $entity->param = 'test';
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame('test', $entity->param->scalar);
        $entity->param = null;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectNotHasProperty('scalar', $entity->param);
    }

    public function test_entity_cast_buildin_type_object_with_default_null(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'object', default: null)]
            protected ?object $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(1, $entity->param->scalar);
        $entity->param = true;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(true, $entity->param->scalar);
        $entity->param = false;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(false, $entity->param->scalar);
        $entity->param = ['prop' => 'test'];
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('prop', $entity->param);
        $this->assertSame('test', $entity->param->prop);
        $entity->param = 'test';
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame('test', $entity->param->scalar);
        $entity->param = null;
        $this->assertSame(null, $entity->param);
    }

    public function test_entity_cast_buildin_type_object_nullable_no_cast(): void
    {
        $entity = new class extends Entity
        {
            #[Property()]
            protected ?object $param;
        };

        $this->assertSame(null, $entity->param);
        $entity->param = 1;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(1, $entity->param->scalar);
        $entity->param = true;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(true, $entity->param->scalar);
        $entity->param = false;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(false, $entity->param->scalar);
        $entity->param = ['prop' => 'test'];
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('prop', $entity->param);
        $this->assertSame('test', $entity->param->prop);
        $entity->param = 'test';
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame('test', $entity->param->scalar);
        $entity->param = null;
        $this->assertSame(null, $entity->param);
    }

    public function test_entity_cast_buildin_type_object_with_default_object(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'object', default: new \stdClass())]
            protected object $param;
        };

        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $entity->param = 1;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(1, $entity->param->scalar);
        $entity->param = true;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(true, $entity->param->scalar);
        $entity->param = false;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame(false, $entity->param->scalar);
        $entity->param = ['prop' => 'test'];
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('prop', $entity->param);
        $this->assertSame('test', $entity->param->prop);
        $entity->param = 'test';
        $this->assertInstanceOf(\stdClass::class, $entity->param);
        $this->assertObjectHasProperty('scalar', $entity->param);
        $this->assertSame('test', $entity->param->scalar);
        $entity->param = null;
        $this->assertInstanceOf(\stdClass::class, $entity->param);
    }

    public function test_entity_cast_buildin_type_object_with_wrong_default_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'object', default: 'text')]
            protected object $param;
        };
    }

    public function test_entity_cast_buildin_type_object_with_wrong_cast_type(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'int')]
            protected object $param;
        };
    }

    /****************************************************************************/
    /*                                  autoUuid                                */
    /****************************************************************************/

    public function test_entity_cast_buildin_type_string_autoUuid(): void
    {
        $entity = new class extends Entity
        {
            #[Property(autoUuid: true)]
            protected string $param;
        };

        $this->assertNotEmpty($entity->param);
        $this->assertIsString($entity->param);
    }

    public function test_entity_cast_buildin_type_string_nullable_autoUuid(): void
    {
        $entity = new class extends Entity
        {
            #[Property(autoUuid: true)]
            protected ?string $param;
        };

        $this->assertNotEmpty($entity->param);
        $this->assertIsString($entity->param);
    }

    public function test_entity_cast_buildin_type_wrong_type_autoUuid(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(autoUuid: true)]
            protected int $param;
        };
    }

    public function test_entity_cast_buildin_type_wrong_cast_autoUuid(): void
    {
        $this->expectException(\TypeError::class);

        new class extends Entity
        {
            #[Property(cast: 'int', autoUuid: true)]
            protected string $param;
        };
    }

    /****************************************************************************/
    /*                                  PROTECTED                               */
    /****************************************************************************/

    public function test_entity_protected_new_object(): void
    {
        $entity = new class extends Entity
        {
            #[Property(protected: true, cast: 'string')]
            protected string $param;
        };

        $this->assertSame('', $entity->param);
        $entity->param = 'test';
        $this->assertSame('test', $entity->param);
        $entity->param = 'test2';
        $this->assertSame('test2', $entity->param);

        $entity->fill(['param' => 'test3']);
        $this->assertSame('test3', $entity->param);
    }

    public function test_entity_protected_new_object_from_source(): void
    {
        $entity = new class extends Entity
        {
            #[Property(protected: true, cast: 'string')]
            protected string $param;
        };

        $entity->fromSource(['param' => 'test']);

        $this->assertSame('test', $entity->param);
        $entity->param = 'test2';
        $this->assertSame('test', $entity->param);

        $entity->fill(['param' => 'test2']);
        $this->assertSame('test', $entity->param);
    }

    /****************************************************************************/
    /*                                   HIDDEN                                 */
    /****************************************************************************/

    public function test_entity_protected_new_object_hidden(): void
    {
        $entity = new class extends Entity
        {
            #[Property(cast: 'string', hidden: true)]
            protected string $param;
        };

        $entity->param = 'test';
        $this->assertSame('test', $entity->param);
        $this->assertArrayNotHasKey('param', $entity->values());
    }

    // test vlastnich castu
    // test vlastnich default values
    // test fromSource
    // test fill
    // test isNew
    // test isdirty
    // test getDirty
    // test values
    // test repository
    // test collection
    // test observer
    // test fire event
}
