<?php

    namespace jeyofdev\Php\Query\Builder\Tests\QueryBuilder;


    use jeyofdev\Php\Query\Builder\Database\Database;
    use jeyofdev\Php\Query\Builder\QueryBuilder\QueryBuilder;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\Syntax;
    use PHPUnit\Framework\TestCase;


    final class QueryBuilderTest extends TestCase
    {
        /**
         * @var QueryBuilder
         */
        private $database;



        /**
         * @var Syntax
         */
        private $syntax;



        /**
         * Get an instance of the query builder
         *
         * @return QueryBuilder
         */
        public function getBuilder () : QueryBuilder
        {
            $this->database = new Database("localhost", "root", "root", "demo");
            $this->syntax = new Syntax();

            return new QueryBuilder($this->database, $this->syntax);
        }



        /**
         * @test
         */
        public function testSelect() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->toSQL();
            $this->assertEquals("SELECT", $query);
        }



        /**
         * @test
         */
        public function testInsert() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->insert()
                ->toSQL();
            $this->assertEquals("INSERT INTO", $query);
        }



        /**
         * @test
         */
        public function testUpdate() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->update()
                ->toSQL();
            $this->assertEquals("UPDATE", $query);
        }



        /**
         * @test
         */
        public function testDelete() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->delete()
                ->toSQL();
            $this->assertEquals("DELETE", $query);
        }
    }

