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
                ->columns()
                ->table("post")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post", $query);
        }



        /**
         * @test
         */
        public function testInsert() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->insert()
                ->table("post")
                ->columns([
                    "id" => ":id",
                    "category" => ":category"
                ])
                ->toSQL();
            $this->assertEquals("INSERT INTO post SET id = :id, category = :category", $query);
        }



        /**
         * @test
         */
        public function testUpdate() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->update()
                ->table("post")
                ->columns([
                    "id" => ":id",
                    "category" => ":category"
                ])
                ->toSQL();
            $this->assertEquals("UPDATE post SET id = :id, category = :category", $query);
        }



        /**
         * @test
         */
        public function testDelete() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->delete()
                ->table("post")
                ->toSQL();
            $this->assertEquals("DELETE FROM post", $query);
        }



        /**
         * @test
         */
        public function testTableNameWithAlias() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post", "p")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post AS p", $query);
        }



        /**
         * @test
         */
        public function testWhereClause() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post", "p")
                ->where("id", ":id", ">=")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post AS p WHERE id >= :id", $query);
        }



        /**
         * @test
         */
        public function testWhereClauseMultiple() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post", "p")
                ->where("id", ":id", ">=")
                ->where("category", ":category", "=", "and")
                ->where("slug", ":slug", "=", "or")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post AS p WHERE id >= :id AND category = :category OR slug = :slug", $query);
        }



        /**
         * @test
         */
        public function testWhereClauseWithOperatorNot() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post", "p")
                ->where("id", ":id", ">=", null, true)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post AS p WHERE NOT id >= :id", $query);
        }



        /**
         * @test
         */
        public function testOrderByClause() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post")
                ->orderBy("id", "DESC")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post ORDER BY id DESC", $query);
        }



        /**
         * @test
         */
        public function testOrderByClauseWithoutDirection() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post")
                ->orderBy("id")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post ORDER BY id ASC", $query);
        }



        /**
         * @test
         */
        public function testOrderByClauseMultiple() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post")
                ->orderBy("id", "DESC")
                ->orderBy("category")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post ORDER BY id DESC, category ASC", $query);
        }



        /**
         * @test
         */
        public function testOrderByClauseAsArray() : void
        {
            $firstQuery = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post")
                ->orderBy([
                    ["id" => "ASC"],
                    ["category" => "DESC"],
                    ["name" => "ASC"]
                ])
                ->toSQL();
            $this->assertEquals("SELECT * FROM post ORDER BY id ASC, category DESC, name ASC", $firstQuery);


            $secondQuery = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post")
                ->orderBy([
                    "id" => "ASC",
                    "category" => "DESC",
                    "name" => "ASC"
                ])
                ->toSQL();
            $this->assertEquals("SELECT * FROM post ORDER BY id ASC, category DESC, name ASC", $secondQuery);
        }



        /**
         * @test
         */
        public function testLimit() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post")
                ->limit(10)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post LIMIT 10", $query);
        }



        /**
         * @test
         */
        public function testLimitAsZero() : void
        {
            $query = $this->getBuilder()->getSyntax()
                ->select()
                ->table("post")
                ->limit(0)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post", $query);
        }
    }

