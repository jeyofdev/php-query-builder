# php-query-builder
Set a sql query builder

<a name="index_block"></a>

* [1. Initialize the Querybuilder](#block1)
* [2. Building Queries](#block2)
    * [2.1. SELECT Statement](#block2.1)     
        * [2.1.1. Basic SELECT statement](#block2.1.1)
* [3. Clause](#block3)
    * [3.1. FROM](#block3.1)
        * [3.1.1. Basic FROM](#block3.1.1)
        * [3.1.2. Alias FROM](#block3.1.2) 
    * [3.2. COLUMNS](#block3.2)
        * [3.2.1. Basic COLUMNS](#block3.2.1)
        * [3.2.2. Set COLUMNS](#block3.2.2)
        * [3.2.3. Set COLUMNS with alias](#block3.2.3)
    * [3.3. WHERE](#block3.3)
        * [3.3.1. Basic WHERE](#block3.3.1)
        * [3.3.2. WHERE multiple](#block3.3.2)
            * [3.3.2.1 WHERE multiple with operator "AND"](#block3.3.2.1)
            * [3.3.2.2 WHERE multiple with operator "OR"](#block3.3.2.2)
            * [3.3.2.3 WHERE multiple with parenthesis](#block3.3.2.3)
        * [3.3.3. WHERE with operator "NOT"](#block3.3.3)
        * [3.3.4. WHERE with operator "IN"](#block3.3.4)
        * [3.3.5. WHERE with operator "BETWEEN"](#block3.3.5)
        * [3.3.6. WHERE with operator "IS NOT NULL" and "IS NULL"](#block3.3.6)
            * [3.3.6.1. with "IS NULL"](#block3.3.6.1)
            * [3.3.6.2. with "IS NOT NULL"](#block3.3.6.2)
        * [3.3.7. WHERE with operator "LIKE"](#block3.3.7)
    * [3.4. ORDER BY](#block3.4)
        * [3.4.1. Basic ORDER BY](#block3.4.1)
        * [3.4.2. ORDER BY with direction](#block3.4.2)
        * [3.4.3. ORDER BY multiple](#block3.4.3)
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
```
#### Output:
```sql
SELECT * FROM post
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
#### 3.3 WHERE [↑](#index_block) 


<a name="block3.3.1"></a>
### 3.3.1. Basic WHERE [↑](#index_block) 

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

<a name="block3.3.2"></a>
### 3.3.2. WHERE multiple [↑](#index_block) 

<a name="block3.3.2.1"></a>
### 3.3.2.1 WHERE multiple with operator "AND" [↑](#index_block) 

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

<a name="block3.3.2.2"></a>
### 3.3.2.2 WHERE multiple with operator "OR" [↑](#index_block) 

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

<a name="block3.3.2.3"></a>
### 3.3.2.3 WHERE multiple with parenthesis [↑](#index_block) 

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

<a name="block3.3.3"></a>
### 3.3.3. WHERE multiple with operator "NOT" [↑](#index_block) 

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

<a name="block3.3.4"></a>
### 3.3.4. WHERE with operator "IN" [↑](#index_block) 

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

<a name="block3.3.5"></a>
### 3.3.5. WHERE with operator "BETWEEN" [↑](#index_block) 

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

<a name="block3.3.6"></a>
### 3.3.6. WHERE with operator "IS NULL" and "IS NOT NULL" [↑](#index_block) 

<a name="block3.3.6.1"></a>
### 3.3.6.1 With Is NULL [↑](#index_block) 

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
<a name="block3.3.6.2"></a>
### 3.3.6.2 With Is NULL [↑](#index_block) 

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

<a name="block3.3.7"></a>
### 3.3.7. WHERE with operator "LIKE" [↑](#index_block) 

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


<a name="block3.4"></a>
#### 3.4 ORDER BY [↑](#index_block) 


<a name="block3.4.1"></a>
### 3.4.1. Basic ORDER BY [↑](#index_block) 

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

<a name="block3.4.2"></a>
### 3.4.2. ORDER BY with direction [↑](#index_block) 

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

<a name="block3.4.3"></a>
### 3.4.3. ORDER BY multiple [↑](#index_block) 

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
SELECT client, SUM(price) AS sum_price FROM sale GROUP BY client HAVING SUM(price) = 30 OR (SUM(price) > 150 OR SUM(price) > 200)
```
