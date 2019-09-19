<?php

    namespace jeyofdev\Php\Query\Builder\Tests\QueryBuilder;


    use jeyofdev\Php\Query\Builder\Database\Database;
    use jeyofdev\Php\Query\Builder\QueryBuilder\QueryBuilder;
    use PDO;
    use PHPUnit\Framework\TestCase;


    final class QueryBuilderTest extends TestCase
    {
        /**
         * @var QueryBuilder
         */
        private $database;



        /**
         * Get an instance of the query builder
         *
         * @return QueryBuilder
         */
        public function getBuilder () : QueryBuilder
        {
            $this->database = new Database("localhost", "root", "root", "demo");
            return new QueryBuilder($this->database);
        }



        /**
         * @test
         */
        public function testSelect() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns()
                ->table("post")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post", $query);
        }



        /**
         * @test
         */
        public function testSelectWithOptions() : void
        {
            $query = $this->getBuilder()
                ->select("DISTINCT")
                ->columns()
                ->table("post")
                ->toSQL();
            $this->assertEquals("SELECT DISTINCT * FROM post", $query);
        }



        /**
         * @test
         */
        public function testInsert() : void
        {
            $query = $this->getBuilder()
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
            $query = $this->getBuilder()
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
            $query = $this->getBuilder()
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
            $query = $this->getBuilder()
                ->select()
                ->table("post", "p")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post AS p", $query);
        }



        /**
         * @test
         */
        public function testJoin() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("c.*", "pc.post_id")
                ->table("post_category", "pc")
                ->join("JOIN", "category", "c")
                ->on("c.id", "pc.category_id")
                ->toSQL();
            $this->assertEquals("SELECT c.*, pc.post_id FROM post_category AS pc JOIN category AS c ON c.id = pc.category_id", $query);
        }



        /**
         * @test
         */
        public function testInnerJoin() : void
        {
                $query = $this->getBuilder()
                ->select()
                ->columns("c.*", "pc.post_id")
                ->table("post_category", "pc")
                ->join("INNER JOIN", "category", "c")
                ->on("pc.category_id", "c.id")
                ->toSQL();
            $this->assertEquals("SELECT c.*, pc.post_id FROM post_category AS pc INNER JOIN category AS c ON pc.category_id = c.id", $query);
    }



    /**
     * @test
     */
    public function testCrossJoin() : void
    {
        $query = $this->getBuilder()
            ->select()
            ->columns("c.*", "pc.post_id")
            ->table("post_category", "pc")
            ->join("CROSS JOIN", "category", "c")
            ->toSQL();
        $this->assertEquals("SELECT c.*, pc.post_id FROM post_category AS pc CROSS JOIN category AS c", $query);
    }



        /**
         * @test
         */
        public function testLeftJoin() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("c.*", "pc.post_id")
                ->table("post_category", "pc")
                ->join("LEFT JOIN", "category", "c")
                ->on("pc.category_id", "c.id")
                ->toSQL();
            $this->assertEquals("SELECT c.*, pc.post_id FROM post_category AS pc LEFT JOIN category AS c ON pc.category_id = c.id", $query);
        }



        /**
         * @test
         */
        public function testRightJoin() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("c.*", "pc.post_id")
                ->table("post_category", "pc")
                ->join("RIGHT JOIN", "category", "c")
                ->on("pc.category_id", "c.id")
                ->toSQL();
            $this->assertEquals("SELECT c.*, pc.post_id FROM post_category AS pc RIGHT JOIN category AS c ON pc.category_id = c.id", $query);
        }



        /**
         * @test
         */
        public function testWhereClause() : void
        {
            $query = $this->getBuilder()
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
            $query = $this->getBuilder()
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
            $query = $this->getBuilder()
                ->select()
                ->table("post", "p")
                ->where("id", ":id", ">=", null, true)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post AS p WHERE NOT id >= :id", $query);
        }



        /**
         * @test
         */
        public function testWhereClauseWithParenthesis() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->where("id", ":id", ">")
                ->where("category", ":category_one", "=", "and", false, true, false)
                ->where("category", ":category_two", "=", "or", false, false, true)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post WHERE id > :id AND (category = :category_one OR category = :category_two)", $query);
        }



        /**
         * @test
         */
        public function testWhereClauseWithOperatorIn() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->where("id", [1, 2, 3], "IN")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post WHERE id IN (1, 2, 3)", $query);
        }



        /**
         * @test
         */
        public function testWhereClauseWithOperatorBetween() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->where("id", [5, 10], "BETWEEN")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post WHERE id BETWEEN 5 AND 10", $query);
        }



        /**
         * @test
         */
        public function testWhereClauseWithOperatorIsNull() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->where("id", null, "IS NULL")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post WHERE id IS NULL", $query);
        }



        /**
         * @test
         */
        public function testWhereClauseWithOperatorLike() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->where("name", 'S%', "LIKE")
                ->toSQL();
            $this->assertEquals("SELECT * FROM post WHERE name LIKE 'S%'", $query);
        }



        /**
         * @test
         */
        public function testGroupBy() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("client")
                ->functionSql("sum", "price", "price_sum")
                ->table("sale")
                ->groupBy("client")
                ->toSQL();
            $this->assertEquals("SELECT client, SUM(price) AS price_sum FROM sale GROUP BY client", $query);
        }



        /**
         * @test
         */
        public function testGroupByWithRollup() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("client")
                ->functionSql("sum", "price", "sum_price")
                ->functionSql("count", "*", "count")
                ->functionSql("max", "price", "max_price")
                ->table("sale")
                ->groupBy("client", true)
                ->toSQL();
            $this->assertEquals("SELECT client, SUM(price) AS sum_price, COUNT(*) AS count, MAX(price) AS max_price FROM sale GROUP BY client WITH ROLLUP", $query);
        }



        /**
         * @test
         */
        public function testHavingClause() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("client")
                ->functionSql("sum", "price", "sum_price")
                ->table("sale")
                ->groupBy("client")
                ->having("sum", "price", 30, ">")
                ->toSQL();
            $this->assertEquals("SELECT client, SUM(price) AS sum_price FROM sale GROUP BY client HAVING SUM(price) > 30", $query);
        }



        /**
         * @test
         */
        public function testHavingClauseMultiple() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("client")
                ->functionSql("sum", "price", "sum_price")
                ->table("sale")
                ->groupBy("client")
                ->having("sum", "price", 30, ">")
                ->having("sum", "price", 50, "<", "and", false)
                ->toSQL();
            $this->assertEquals("SELECT client, SUM(price) AS sum_price FROM sale GROUP BY client HAVING SUM(price) > 30 AND SUM(price) < 50", $query);
        }



        /**
         * @test
         */
        public function testHavingClauseWithOperatorNot() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("client")
                ->functionSql("sum", "price", "sum_price")
                ->table("sale")
                ->groupBy("client")
                ->having("sum", "price", 30, ">", null, true)
                ->toSQL();
            $this->assertEquals("SELECT client, SUM(price) AS sum_price FROM sale GROUP BY client HAVING NOT SUM(price) > 30", $query);
        }



        /**
         * @test
         */
        public function testHavingClauseWithParenthesis() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("client")
                ->functionSql("sum", "price", "sum_price")
                ->table("sale")
                ->groupBy("client")
                ->having("sum", "price", 30, ">")
                ->having("sum", "price", 50, "<", "and", false, true, false)
                ->having("sum", "price", [56, 143], "IN", "or", false, false, true)
                ->toSQL();
            $this->assertEquals("SELECT client, SUM(price) AS sum_price FROM sale GROUP BY client HAVING SUM(price) > 30 AND (SUM(price) < 50 OR SUM(price) IN (56, 143))", $query);
        }



        /**
         * @test
         */
        public function testHavingClauseWithOperatorIn() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("client")
                ->functionSql("sum", "price", "sum_price")
                ->table("sale")
                ->groupBy("client")
                ->having("sum", "price", [56, 143], "IN")
                ->toSQL();
            $this->assertEquals("SELECT client, SUM(price) AS sum_price FROM sale GROUP BY client HAVING SUM(price) IN (56, 143)", $query);
        }



        /**
         * @test
         */
        public function testHavingClauseWithOperatorBetween() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("client")
                ->functionSql("sum", "price", "sum_price")
                ->table("sale")
                ->groupBy("client")
                ->having("sum", "price", [50, 100], "BETWEEN")
                ->toSQL();
            $this->assertEquals("SELECT client, SUM(price) AS sum_price FROM sale GROUP BY client HAVING SUM(price) BETWEEN 50 AND 100", $query);
        }



        /**
         * @test
         */
        public function testHavingClauseWithOperatorIsNull() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->columns("client")
                ->functionSql("sum", "price", "sum_price")
                ->table("sale")
                ->groupBy("client")
                ->having("sum", "price", null, "IS NULL")
                ->toSQL();
            $this->assertEquals("SELECT client, SUM(price) AS sum_price FROM sale GROUP BY client HAVING SUM(price) IS NULL", $query);
        }



        /**
         * @test
         */
        public function testOrderByClause() : void
        {
            $query = $this->getBuilder()
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
            $query = $this->getBuilder()
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
            $query = $this->getBuilder()
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
            $firstQuery = $this->getBuilder()
                ->select()
                ->table("post")
                ->orderBy([
                    ["id" => "ASC"],
                    ["category" => "DESC"],
                    ["name" => "ASC"]
                ])
                ->toSQL();
            $this->assertEquals("SELECT * FROM post ORDER BY id ASC, category DESC, name ASC", $firstQuery);


            $secondQuery = $this->getBuilder()
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
            $query = $this->getBuilder()
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
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->limit(0)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post", $query);
        }



        /**
         * @test
         */
        public function testOffset() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->limit(5)
                ->offset(3)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post LIMIT 5 OFFSET 3", $query);
        }



        /**
         * @test
         */
        public function testOffsetAsZero() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->limit(5)
                ->offset(0)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post LIMIT 5", $query);
        }



        /**
         * @test
         */
        public function testOffsetWithMethodPage() : void
        {
            $firstQuery = $this->getBuilder()
                ->select()
                ->table("post")
                ->limit(5)
                ->page(3)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post LIMIT 5 OFFSET 10", $firstQuery);

            $lastQuery = $this->getBuilder()
                ->select()
                ->table("post")
                ->limit(5)
                ->page(1)
                ->toSQL();
            $this->assertEquals("SELECT * FROM post LIMIT 5", $lastQuery);
        }



        /**
         * @test
         */
        public function testExec() : void
        {
            $query = $this->getBuilder()
                ->delete()
                ->table("post")
                ->where("id", 10, ">")
                ->toSql();
            $this->assertEquals("DELETE FROM post WHERE id > 10", $query);
            

            $result = $this->getBuilder()->exec($query);
            $this->assertGreaterThanOrEqual(0, $result);
        }



        /**
         * @test
         */
        public function testFetch() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->where("id", ":id", ">")
                ->toSql();
            $this->assertEquals("SELECT * FROM post WHERE id > :id", $query);
            

            $results = $this->getBuilder()
                ->prepare($query)
                ->execute(["id" => 5])
                ->fetch("OBJ");

            $this->assertNotEmpty($results);
        }



        /**
         * @test
         */
        public function testFetchAll() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->where("id", ":id", ">")
                ->toSql();
            $this->assertEquals("SELECT * FROM post WHERE id > :id", $query);
            

            $results = $this->getBuilder()
                ->prepare($query)
                ->execute(["id" => 5])
                ->fetchAll("OBJ");

            $this->assertNotEmpty($results);
        }



        /**
         * @test
         */
        public function testFetchLastInsertId() : void
        {
            $query = $this->getBuilder()
                ->select()
                ->table("post")
                ->where("id", ":id", ">")
                ->toSql();
            $this->assertEquals("SELECT * FROM post WHERE id > :id", $query);
            

            $results = $this->getBuilder()
                ->lastInsertId();

            $this->assertNotNull($results);
        }



        /**
         * @test
         */
        public function testPDOQuote() : void
        {
            $value = $this->getBuilder()->quote("lorem ipsum");
            $this->assertEquals("'lorem ipsum'", $value);
        }



        /**
         * @test
         */
        public function testRowCount() : void
        {
            $query = $this->getBuilder()
                ->delete()
                ->table("post")
                ->where("id", ":id", ">")
                ->toSql();
            $this->assertEquals("DELETE FROM post WHERE id > :id", $query);
            
            $count = $this->getBuilder()
                ->prepare($query)
                ->execute(["id" => 8])
                ->rowCount();

            $this->assertGreaterThanOrEqual(0, $count);
        }



        /**
         * @test
         */
        public function testPDOSetAttribute() : void
        {
            $attribute = $this->getBuilder()
                ->setAttribute([
                    "ERRMODE" => "EXCEPTION"
                ])
                ->getAttribute("ERRMODE");

            $this->assertEquals(2, $attribute);
        }
    }