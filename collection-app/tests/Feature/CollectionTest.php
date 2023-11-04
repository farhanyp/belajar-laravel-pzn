<?php

namespace Tests\Feature;

use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\LazyCollection;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    public function testCreateCollection(): void
    {
        $collection = collect([1,2,3]);

        self::assertEqualsCanonicalizing([1,2,3], $collection->all());
    }

    public function testForEach(): void
    {
        $collection = collect([1,2,3,4,5]);
        foreach ($collection as $key => $value){
            self::assertEquals($key + 1, $value);
        }
    }

    public function testCrud(): void
    {
        $collection = collect([]);
        $collection->push(1,2,3);
        self::assertEqualsCanonicalizing([1,2,3], $collection->all());

        $result = $collection->pop();
        self::assertEquals(3, $result);
        self::assertEqualsCanonicalizing([1,2], $collection->all());
    }

    public function testMap(): void
    {
        $collection = collect([1,2,3]);
        $result = $collection->map(function ($item){
            return $item * 2;
        });

        self::assertEquals([2,4,6],$result->all());
    }

    public function testMapInto(): void
    {
        $collection = collect(["Yp"]);
        $result = $collection->mapInto(Person::class);

        self::assertEquals([new Person("Yp")], $result->all());
    }

    public function testMapSpread(): void
    {
        $collection = collect([["Farhan", "Yudha"], ["Yp", "Pratama"]]);
        $result = $collection->mapSpread(function($firstname, $lastname){
            $fullname = $firstname . " " . $lastname;
            return new Person($fullname);
        });

        self::assertEquals([
            new Person("Farhan Yudha"),
            new Person("Yp Pratama")
        ], $result->all());
    }

    public function testMapToGroups(): void
    {
        $collection = collect([
            [
                "name" =>"Yp",
                "department" => "IT"
            ],
            [
                "name" =>"Farhan",
                "department" => "IT"
            ],
            [
                "name" =>"Yudha",
                "department" => "HR"
            ]
        ]);

        $result = $collection->mapToGroups(function($item){
            return [$item["department"] => $item["name"]];
        });

        self::assertEquals([
            "IT" => collect(["Yp", "Farhan"]),
            "HR" => collect(["Yudha"])
        ], $result->all());
    }

    public function testZip(): void
    {
        $collection1 = collect([1,2,3]);
        $collection2 = collect([4,5,6]);
        $collection3 = $collection1->zip($collection2);

        self::assertEquals([
            collect([1,4]),
            collect([2,5]),
            collect([3,6]),
        ], $collection3->all());
    }

    public function testConcat(): void
    {
        $collection1 = collect([1,2,3]);
        $collection2 = collect([4,5,6]);
        $collection3 = $collection1->concat($collection2);

        self::assertEquals([1,2,3,4,5,6], $collection3->all());
    }

    public function testCombine(): void
    {
        $collection1 = ["name", "country"];
        $collection2 = ["Yp", "Indonesia"];
        $collection3 = collect($collection1)->combine($collection2);

        self::assertEquals([
            "name" => "Yp",
            "country" => "Indonesia"
        ], $collection3->all());
    }

    public function testCollapse(): void
    {
        $collection = collect([
            [1,2,3],
            [4,5,6],
            [7,8,9]
        ]);

        $result = $collection->collapse();
        self::assertEquals([1,2,3,4,5,6,7,8,9], $result->all());
    }

    public function testFlatMap(): void
    {
        $collection = collect([
            [1,2,3],
            [4,5,6],
            [7,8,9]
        ]);

        $result = $collection->collapse();
        self::assertEquals([1,2,3,4,5,6,7,8,9], $result->all());
    }

    public function testJoin(): void
    {
        $collection = collect(["Farhan", "Yudha", "Pratama"]);

        self::assertEquals("Farhan-Yudha-Pratama", $collection->join("-"));
        self::assertEquals("Farhan-Yudha_Pratama", $collection->join("-", "_"));
    }

    public function testFilter(): void
    {
        $collection = collect([
            "Farhan" => 100, 
            "Yudha" => 80, 
            "Pratama" => 90
        ]);

        $result = $collection->filter(function ($item, $key){
            return $item >= 90;
        });

        self::assertEquals([
            "Farhan" => 100,
            "Pratama" => 90,
        ], $result->all());
    }

    public function testPartition(): void
    {
        $collection = collect([
            "Farhan" => 100, 
            "Yudha" => 80, 
            "Pratama" => 90
        ]);

        [$result1, $result2] = $collection->partition(function ($item, $key){
            return $item >= 90;
        });

        self::assertEquals([
            "Farhan" => 100,
            "Pratama" => 90,
        ], $result1->all());

        self::assertEquals([
            "Yudha" => 80,
        ], $result2->all());
    }

    public function testTesting(): void
    {
        $collection = collect([ "Farhan", "Yudha", "Pratama" ]);

        self::assertTrue($collection->contains("Farhan"));
        self::assertTrue($collection->contains(function($value, $key){
            return $value == "Yudha";
        }));
    }

    public function testGrouping(): void
    {
        $collection = collect([
            [
                "name" => "Farhan",
                "department" => "IT",
            ],
            [
                "name" => "Yudha",
                "department" => "IT",
            ],
            [
                "name" => "Pratama",
                "department" => "HR",
            ]
        ]);

        $result = $collection->groupBy("department");

        self::assertEquals([
                "IT" => collect([
                    [
                        "name" => "Farhan",
                        "department" => "IT",
                    ],
                    [
                        "name" => "Yudha",
                        "department" => "IT",
                    ]
                ]),
                "HR" => collect([
                    [
                        "name" => "Pratama",
                        "department" => "HR",
                    ]
                ])
        ], $result->all());
    }

    public function testSlicing(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);
        $result = $collection->slice(3);
        self::assertEqualsCanonicalizing([4,5,6,7,8,9], $result->all());

        $result = $collection->slice(3,2);
        self::assertEqualsCanonicalizing([4,5], $result->all());
    }

    public function testTake(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);
        $result = $collection->take(3);
        self::assertEqualsCanonicalizing([1,2,3], $result->all());

        $result = $collection->takeUntil(function ($value, $key){
            return $value == 3;
        });
        self::assertEqualsCanonicalizing([1,2], $result->all());

        $result = $collection->takeWhile(function ($value, $key){
            return $value < 3;
        });
        self::assertEqualsCanonicalizing([1,2], $result->all());
    }

    public function testSkip(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);
        $result = $collection->skip(3);
        self::assertEqualsCanonicalizing([4,5,6,7,8,9], $result->all());

        $result = $collection->skipUntil(function ($value, $key){
            return $value == 3;
        });
        self::assertEqualsCanonicalizing([3,4,5,6,7,8,9], $result->all());

        $result = $collection->skipWhile(function ($value, $key){
            return $value < 3;
        });
        self::assertEqualsCanonicalizing([3,4,5,6,7,8,9], $result->all());
    }

    public function testChunked(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);
        $result = $collection->chunk(3);

        self::assertEqualsCanonicalizing([1,2,3], $result->all()[0]->all());
        self::assertEqualsCanonicalizing([4,5,6], $result->all()[1]->all());
        self::assertEqualsCanonicalizing([7,8,9], $result->all()[2]->all());
    }

    public function testFirst(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);
        $result = $collection->first();

        self::assertEquals(1, $result);

        $result = $collection->first(function($value, $key){
            return $value > 5;
        });
        self::assertEquals(6, $result);
    }

    public function testLast(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);
        $result = $collection->last();

        self::assertEquals(9, $result);

        $result = $collection->last(function($value, $key){
            return $value < 5;
        });
        self::assertEquals(4, $result);
    }

    public function testRandom(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);
        $result = $collection->random();

        self::assertTrue(in_array($result, [1,2,3,4,5,6,7,8,9]));
    }

    public function testCheckingExistence(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);

        self::assertTrue($collection->isNotEmpty());
        self::assertFalse($collection->isEmpty());
        self::assertTrue($collection->contains(8));
        self::assertFalse($collection->contains(10));
        self::assertTrue($collection->contains(function($value, $key){
            return $value == 8;
        }));
    }

    public function testOrdering(): void
    {
        $collection = collect([1,2,3,4]);
        $result = $collection->sort();

        self::assertEqualsCanonicalizing([1,2,3,4], $result->all());

        $result = $collection->sortDesc();

        self::assertEqualsCanonicalizing([4,3,2,1], $result->all());
    }

    public function testAggregate(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);
        $result = $collection->sum();
        self::assertEquals(45, $result);

        $result = $collection->avg();
        self::assertEquals(5, $result);

        $result = $collection->min();
        self::assertEquals(1, $result);

        $result = $collection->max();
        self::assertEquals(9, $result);
    }

    public function testReduce(): void
    {
        $collection = collect([1,2,3,4,5,6,7,8,9]);
        $result = $collection->reduce(function($carry, $item){
            return $carry + $item;
        });

        self::assertEquals(45, $result);
    }

    public function testLazyCollection(): void
    {
        $collection = LazyCollection::make(function (){
            $value = 0;
            while(true){
                yield $value;
                $value++;
            }
        });

        $result = $collection->take(10);
        self::assertEqualsCanonicalizing([0,1,2,3,4,5,6,7,8,9], $result->all());
    }
}
