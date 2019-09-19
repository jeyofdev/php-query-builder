# php-query-builder
Set a sql query builder

<a name="index_block"></a>

* [1. Initialize the Querybuilder](#block1)
* [2. Building Queries](#block2)
    * [2.1. SELECT Statement](#block2.1)
        * [2.1.1. Basic SELECT Statement](#block2.1.1)
        * [2.1.2. SELECT with COLUMNS statement](#block2.1.2)
        * [2.1.3. SELECT with WHERE statement](#block2.1.3)    
        * [2.1.4. SELECT with ORDER BY statement](#block2.1.4)
        * [2.1.5. SELECT with LIMIT and OFFSET statement](#block2.1.5)
        * [2.1.6. SELECT with JOIN statement](#block2.1.6)
        * [2.1.7. SELECT with GROUP BY statement](#block2.1.7) 
        * [2.1.8. SELECT with HAVING statement](#block2.1.8) 
    * [2.2. INSERT INTO Statement](#block2.2) 
    * [2.3. UPDATE Statement](#block2.3)     
    * [2.4. DELETE Statement](#block2.4)     
* [3. Clause](#block3)
    * [3.1. FROM](#block3.1)
        * [3.1.1. Basic FROM](#block3.1.1)
        * [3.1.2. Alias FROM](#block3.1.2) 
    * [3.2. COLUMNS](#block3.2)
        * [3.2.1. Basic COLUMNS](#block3.2.1)
        * [3.2.2. Set COLUMNS](#block3.2.2)
        * [3.2.3. Set COLUMNS with alias](#block3.2.3)
    * [3.3. JOIN/INNER JOIN/CROSS JOIN/JOIN LEFT/ JOIN RIGHT/FULL JOIN ](#block3.3)
    * [3.4. WHERE](#block3.4)
        * [3.4.1. Basic WHERE](#block3.4.1)
        * [3.4.2. WHERE multiple](#block3.4.2)
            * [3.4.2.1 WHERE multiple with operator "AND"](#block3.4.2.1)
            * [3.4.2.2 WHERE multiple with operator "OR"](#block3.4.2.2)
            * [3.4.2.3 WHERE multiple with parenthesis](#block3.4.2.3)
        * [3.4.3. WHERE with operator "NOT"](#block3.4.3)
        * [3.4.4. WHERE with operator "IN"](#block3.4.4)
        * [3.4.5. WHERE with operator "BETWEEN"](#block3.4.5)
        * [3.4.6. WHERE with operator "IS NOT NULL" and "IS NULL"](#block3.4.6)
            * [3.4.6.1. WHERE with "IS NULL"](#block3.4.6.1)
            * [3.4.6.2. WHERE with "IS NOT NULL"](#block3.4.6.2)
        * [3.4.7. WHERE with operator "LIKE"](#block3.4.7)
    * [3.5. ORDER BY](#block3.5)
        * [3.5.1. Basic ORDER BY](#block3.5.1)
        * [3.5.2. ORDER BY with direction](#block3.5.2)
        * [3.5.3. ORDER BY multiple](#block3.5.3)
    * [3.5. LIMIT and OFFSET](#block3.5)
        * [3.5.1. Basic LIMIT](#block3.5.1)
        * [3.5.2. Basic LIMIT and OFFSET](#block3.5.2)
        * [3.5.3. Dynamic OFFSET](#block3.5.3)
* [4. Advanced Clause](#block4)
    * [4.1. GROUP BY](#block4.1)
        * [4.1.1. Basic GROUP BY](#block4.1.1)
        * [4.1.2. GROUP BY with ROLLUP](#block4.1.2)
    * [4.2. HAVING](#block4.2)
        * [4.2.1. Basic HAVING](#block4.2.1)
        * [4.2.2. HAVING multiple](#block4.2.2)
            * [4.2.2.1 HAVING multiple with operator "AND"](#block4.2.2.1)
            * [4.2.2.2 HAVING multiple with operator "OR"](#block4.2.2.2)
            * [4.2.2.3 HAVING multiple with parenthesis](#block4.2.2.3)
        * [4.2.3. HAVING with operator "NOT"](#block4.2.3)
        * [4.2.4. HAVING with operator "IN"](#block4.2.4)
        * [4.2.5. HAVING with operator "BETWEEN"](#block4.2.5)
        * [4.2.6. HAVING with operator "IS NOT NULL" and "IS NULL"](#block4.2.6)
            * [4.2.6.1. HAVING with "IS NULL"](#block4.2.6.1)
            * [4.2.6.2. HAVING with "IS NOT NULL"](#block4.2.6.2)
* [5. Execute the query](#block5)
    * [5.1. Type QUERY](#block5.1)  
    * [5.2. Type PREPARE](#block5.2)
    * [5.3. Type EXEC](#block5.3)
* [6. Get the results of the query](#block6)
    * [6.1. FETCH](#block6.1)
    * [6.2. FETCHALL](#block6.2)
    * [6.3. lastInsertId](#block6.3)
* [7. PDO Attributes](#block7)
    * [7.1. PDO Attributes](#block7.1)
    * [7.2. PDO Attributes](#block7.2)



<a name="block1"></a>
## 1. Initialize the Querybuilder [↑](#index_block) 

```php
use jeyofdev\Php\Query\Builder\Database\Database;
use jeyofdev\Php\Query\Builder\QueryBuilder\QueryBuilder;

$database = new Database("localhost", "root", "root", "demo");
$queryBuilder = new QueryBuilder($database);
```



<a name="block2"></a>
## 2. Building Queries [↑](#index_block)

<a name="block2.1"></a>
### 2.1. SELECT Statement [↑](#index_block) 

<a name="block2.1.1"></a>
#### 2.1.1. Basic SELECT statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->toSQL();

$results = $queryBuilder
    ->query($query)
    ->fetchAll("FETCH_OBJ");
```

<a name="block2.1.2"></a>
#### 2.1.2. SELECT with COLUMNS statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("id", "name", "slug")
    ->table("post")
    ->toSQL();

$results = $queryBuilder
    ->query($query)
    ->fetchAll("FETCH_OBJ");
```

<a name="block2.1.3"></a>
#### 2.1.3. SELECT with WHERE statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("id", "name", "slug")
    ->table("post")
    ->where("id", ":id", ">=")
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "id" => 5
    ])
    ->fetchAll("FETCH_OBJ");
```

<a name="block2.1.4"></a>
#### 2.1.4. SELECT with ORDER BY statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("id", "name", "slug")
    ->table("post")
    ->where("id", ":id", ">=")
    ->orderby("id", "DESC")
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "id" => 5
    ])
    ->fetchAll("FETCH_OBJ");
```

<a name="block2.1.5"></a>
#### 2.1.5. SELECT with LIMIT and OFFSET statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("id", "name", "slug")
    ->table("post")
    ->where("id", ":id", ">=")
    ->orderby("id", "DESC")
    ->limit(5)
    ->offset(10)
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "id" => 5
    ])
    ->fetchAll("FETCH_OBJ");
```

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("id", "name", "slug")
    ->table("post")
    ->where("id", ":id", ">=")
    ->orderby("id", "DESC")
    ->limit(5)
    ->page(2)
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "id" => 5
    ])
    ->fetchAll("FETCH_OBJ");
```



<a name="block2.1.6"></a>
#### 2.1.6. SELECT with JOIN statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("p.*", "pc.post_id")
    ->table("post_category", "pc")
    ->join("JOIN", "post", "p")
    ->on("p.id", "pc.category_id")
    ->where("id", ":id", ">=")
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "id" => 5
    ])
    ->fetchAll("FETCH_OBJ");
```

<a name="block2.1.7"></a>
#### 2.1.7. SELECT with GROUP BY statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", 30, ">")
    ->toSql();

$results = $queryBuilder
    ->prepare($query)
    ->execute()
    ->fetchAll("FETCH_OBJ");
```

<a name="block2.1.8"></a>
#### 2.1.8. SELECT with HAVING statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->toSql();

$results = $queryBuilder
    ->prepare($query)
    ->execute()
    ->fetchAll("FETCH_OBJ");
```


<a name="block2.2"></a>
### 2.2. INSERT Statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->insert()
    ->table("post")
    ->columns([
        "name" => ":name",
        "slug" => ":slug",
        "content" => ":content"
    ])
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "name" => "First title",
        "slug" => "first-title",
        "content" => "lorem ipsum"
    ]);
```

<a name="block2.3"></a>
### 2.3. UPDATE Statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->update()
    ->table("post")
    ->columns([
        "name" => ":name",
        "slug" => ":slug",
        "content" => ":content"
    ])
    ->where("id", 5, "=")
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "name" => "New title",
        "slug" => "new-title",
        "content" => "lorem"
    ]);
```



<a name="block2.3"></a>
### 2.3. DELETE Statement [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->delete()
    ->table("post")
    ->where("id", ":id", "<")
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "id" => 2
    ]);
```



<a name="block3"></a>
## 3. Clauses [↑](#index_block)


<a name="block3.1"></a>
#### 3.1 FROM [↑](#index_block) 


<a name="block3.1.1"></a>
### 3.1.1. Basic FROM [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post
```

<a name="block3.1.2"></a>
### 3.1.2 Alias FROM [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post", "p)
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post AS p
```


<a name="block3.2"></a>
#### 3.2 COLUMNS [↑](#index_block) 

<a name="block3.2.1"></a>
### 3.2.1. Basic COLUMNS [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->toSQL();
```
or
```php
$query = $queryBuilder
    ->select()
    ->columns()
    ->table("post")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post
```

<a name="block3.2.2"></a>
### 3.2.2. Set COLUMNS [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("id", "name", "content")
    ->table("post")
    ->toSQL();
```
#### Output:
```sql
SELECT id, name, content FROM post
```

<a name="block3.2.3"></a>
### 3.2.3. Set COLUMNS with alias [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns([
        "p.id" => "postId", 
        "p.name" => "postName"
    ])
    ->table("post", "p")
    ->toSQL();
```
#### Output:
```sql
SELECT p.id AS postId, name AS postName FROM post AS p
```

<a name="block3.3"></a>
#### 3.3 JOIN/INNER JOIN/CROSS JOIN/JOIN LEFT/ JOIN RIGHT/FULL JOIN [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("c.*", "pc.post_id")
    ->table("post_category", "pc")
    ->join("JOIN", "category", "c")
    ->on("c.id", "pc.category_id")
    ->toSQL();
```
#### Output:
```sql
SELECT c.*, pc.post_id FROM post_category AS pc JOIN category AS c ON c.id = pc.category_id
```

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("c.*", "pc.post_id")
    ->table("post_category", "pc")
    ->join("LEFT JOIN", "category", "c")
    ->on("c.id", "pc.category_id")
    ->toSQL();
```
#### Output:
```sql
SELECT c.*, pc.post_id FROM post_category AS pc LEFT JOIN category AS c ON c.id = pc.category_id"
```





<a name="block3.4"></a>
#### 3.4 WHERE [↑](#index_block) 

<a name="block3.4.1"></a>
### 3.4.1. Basic WHERE [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", ":id, ">=")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE id >= :id
```

<a name="block3.4.2"></a>
### 3.4.2. WHERE multiple [↑](#index_block) 

<a name="block3.4.2.1"></a>
### 3.4.2.1 WHERE multiple with operator "AND" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", ":id", ">=")
    ->where("slug", ":slug", "=", "and")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE id >= :id AND slug = :slug
```

<a name="block3.4.2.2"></a>
### 3.4.2.2 WHERE multiple with operator "OR" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", ":id", "=")
    ->where("slug", ":slug", "=", "or")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE id = :id OR slug = :slug
```

<a name="block3.4.2.3"></a>
### 3.4.2.3 WHERE multiple with parenthesis [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", ":id", ">")
    ->where("slug", ":slugA", "=", "and", false, true, false)
    ->where("slug", ":slugB", "=", "or", false, false, true)
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE id > :id AND (slug = :slugA OR slug = :slugB)
```

<a name="block3.4.3"></a>
### 3.4.3. WHERE multiple with operator "NOT" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", ":id", ">=", null, true)
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE NOT id >= :id
```

<a name="block3.4.4"></a>
### 3.4.4. WHERE with operator "IN" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", [1, 2, 3], "IN")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE id IN (1, 2, 3)
```

<a name="block3.4.5"></a>
### 3.4.5. WHERE with operator "BETWEEN" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", [5, 10], "BETWEEN")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE id BETWEEN 5 AND 10
```

<a name="block3.4.6"></a>
### 3.4.6. WHERE with operator "IS NULL" and "IS NOT NULL" [↑](#index_block) 

<a name="block3.4.6.1"></a>
### 3.4.6.1 Where with IS NULL [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", null, "IS NULL")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE id IS NULL
```
<a name="block3.4.6.2"></a>
### 3.4.6.2 WHERE with IS NOT NULL [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", null, "IS NOT NULL")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE id IS NOT NULL
```

<a name="block3.4.7"></a>
### 3.4.7. WHERE with operator "LIKE" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("name", "S%", "LIKE")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post WHERE name LIKE 'S%'
```


<a name="block3.5"></a>
#### 3.5 ORDER BY [↑](#index_block) 


<a name="block3.5.1"></a>
### 3.5.1. Basic ORDER BY [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->orderBy("id")
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post ORDER BY id ASC
```

<a name="block3.5.2"></a>
### 3.5.2. ORDER BY with direction [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->orderBy("id", "desc)
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post ORDER BY id DESC
```

<a name="block3.5.3"></a>
### 3.5.3. ORDER BY multiple [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->orderBy("id", "DESC")
    ->orderBy("name")
    ->toSQL();
```
or 
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->orderBy([
        "id" => "DESC",
        "name" => "ASC
    ])
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post ORDER BY id DESC, name ASC
```


<a name="block3.5"></a>
#### 3.5 LIMIT and OFFSET [↑](#index_block) 

<a name="block3.5.1"></a>
### 3.5.1. Basic LIMIT [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->limit(10)
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post LIMIT 10
```

<a name="block3.5.2"></a>
### 3.5.2. Basic LIMIT and OFFSET [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->limit(10)
    ->offset(20)
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post LIMIT 10 OFFSET 20
```

<a name="block3.5.3"></a>
### 3.5.3. Dynamic OFFSET [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->limit(10)
    ->page(3)
    ->toSQL();
```
#### Output:
```sql
SELECT * FROM post LIMIT 10 OFFSET 20
```


<a name="block4"></a>
## 4. Advanced Clause [↑](#index_block)

<a name="block4.1"></a>
#### 4.1 GROUP BY [↑](#index_block)

<a name="block4.1.1"></a>
### 4.1.1. Basic GROUP BY [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client
```

<a name="block4.1.2"></a>
### 4.1.2. GROUP BY with ROLLUP [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->functionSql("count", "*", "count")
    ->functionSql("max", "price", "priceMax")
    ->table("sale")
    ->groupBy("client", true)
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal, COUNT(*) AS count, MAX(price) AS priceMax FROM sale GROUP BY client WITH ROLLUP
```


<a name="block4.2"></a>
#### 4.2 HAVING [↑](#index_block)

<a name="block4.2.1"></a>
### 4.2.1. Basic HAVING [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", 30, ">")
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client HAVING SUM(price) > 30
```

<a name="block4.2.2"></a>
### 4.2.2. HAVING multiple [↑](#index_block) 

<a name="block4.2.2.1"></a>
### 4.2.2.1 HAVING multiple with operator "AND" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", 30, ">")
    ->having("sum", "price", 150, "<", "and")
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client HAVING SUM(price) > 30 AND SUM(price) < 150
```

<a name="block4.2.2.2"></a>
### 4.2.2.2 HAVING multiple with operator "OR" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", 30, "=")
    ->having("sum", "price", 150, "=", "or")
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client HAVING SUM(price) = 30 OR SUM(price) = 150
```

<a name="block4.2.2.3"></a>
### 4.2.2.3 HAVING multiple with parenthesis [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", 30, "=")
    ->having("sum", "price", 150, "=", "or", false, true, false)
    ->having("sum", "price", 200, "=", "or", false, false, true)
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client HAVING SUM(price) = 30 OR (SUM(price) > 150 OR SUM(price) > 200)
```

<a name="block4.2.3"></a>
### 4.2.3. HAVING with operator "NOT" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", 30, ">", null, true)
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client HAVING NOT SUM(price) > 30
```

<a name="block4.2.4"></a>
### 4.2.4. HAVING with operator "IN" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", [56, 143], "IN")
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client HAVING SUM(price) IN (56, 143)
```

<a name="block4.2.5"></a>
### 4.2.5. HAVING with operator "BETWEEN" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", [30, 150], "BETWEEN")
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client HAVING SUM(price) BETWEEN 30 AND 150
```

<a name="block4.2.6"></a>
### 4.2.6. HAVING with operator "IS NOT NULL" and "IS NULL" [↑](#index_block) 

<a name="block4.2.6.1"></a>
### 4.2.6.1 HAVING with "IS NULL" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", null, "IS NULL")
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client HAVING SUM(price) IS NULL
```

<a name="block4.2.6.2"></a>
### 4.2.6.2 HAVING with "IS NOT NULL" [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->columns("client")
    ->functionSql("sum", "price", "priceTotal")
    ->table("sale")
    ->groupBy("client")
    ->having("sum", "price", null, "IS NOT NULL")
    ->toSQL();
```
#### Output:
```sql
SELECT client, SUM(price) AS priceTotal FROM sale GROUP BY client HAVING SUM(price) IS NOT NULL
```


<a name="block5"></a>
## 5. Execute the query [↑](#index_block)

<a name="block5.1"></a>
### 5.1. Type QUERY [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", 5, "<=")
    ->toSQL();

$results = $this->getBuilder()
    ->query($query)
    ->fetchAll("FETCH_OBJ");
```

<a name="block5.2"></a>
### 5.2. Type PREPARE [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", ":id", "<=")
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "id" => 5
    ])
    ->fetchAll("FETCH_OBJ");
```

<a name="block5.3"></a>
### 5.3. Type EXEC [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->delete()
    ->table("post")
    ->where("id", 5, "<=")
    ->toSQL();

$results = $queryBuilder
    ->exec($query);
```

<a name="block6"></a>
## 6. Get the results of the query [↑](#index_block)

<a name="block6.1"></a>
### 6.1. FETCH [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", ":id", "=")
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "id" => 5
    ])
    ->fetch("FETCH_OBJ");
```

<a name="block6.2"></a>
### 6.2. FETCHALL [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->select()
    ->table("post")
    ->where("id", ":id", "<=")
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "id" => 5
    ])
    ->fetchAll("FETCH_OBJ");
```

<a name="block6.3"></a>
### 6.3. LastInsertId [↑](#index_block) 

#### Usage:
```php
$query = $queryBuilder
    ->insert()
    ->table("post")
    ->columns([
        "name" => ":name",
        "slug" => ":slug",
        "content" => ":content"
    ])
    ->toSQL();

$results = $queryBuilder
    ->prepare($query)
    ->execute([
        "name" => "First title",
        "slug" => "first-title",
        "content" => "lorem ipsum"
    ])
    ->lastInsertId();
```


<a name="block7"></a>
### 7. PDO attibutes [↑](#index_block)

<a name="block7.1"></a>
### 7.1. Set attributes [↑](#index_block) 

#### Usage:
```php
$queryBuilder->setAttribute([
    "ERRMODE" => PDO::ERRMODE_EXCEPTION
]);
```


<a name="block7.2"></a>
### 7.2. Get attributes [↑](#index_block) 

#### Usage:
```php
$attributes = $queryBuilder->getAttribute("ERRMODE");
