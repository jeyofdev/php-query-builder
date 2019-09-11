<?php

    namespace jeyofdev\Php\Query\Builder\Fixtures;


    use Faker\Factory;
    use jeyofdev\Php\Query\Builder\Database\Database;


    /**
     * Manages the fakes datas
     */
    class Fixtures
    {
        /**
         * Connexion to the database
         *
         * @var Database
         */
        private $database;



        /**
         * @param Database $database
         */
        public function __construct (Database $database)
        {
            $this->database = $database;
        }



        /**
         * Add fixtures
         *
         * @param  string       $locale        The locale (ex: fr_FR, en_US)
         * @param  array|string ...$tableName  The name of the table
         * @return self
         */
        public function add (string $locale, string ...$tableName) : self
        {
            $faker = Factory::create($locale);

            $posts = [];
            $categories = [];

            foreach ($tableName as $key => $table) {
                if ($key === 0) {
                    for ($i = 0; $i < 20; $i++) { 
                        $this->database->getPDO()->exec("INSERT INTO {$table} SET 
                            name = '{$faker->sentence(5, true)}',
                            slug = '{$faker->slug}',
                            created_at = '{$faker->date} {$faker->time}',
                            content = '{$faker->paragraphs(rand(3,15), true)}'
                        ");
                        $posts[] = $this->database->getPDO()->lastInsertId();
                    }
                }

                else if ($key === 1) {
                    for ($i = 0; $i < 5; $i++) { 
                        $this->database->getPDO()->exec("INSERT INTO {$table} SET 
                            name = '{$faker->sentence(2, true)}',
                            slug = '{$faker->slug}'
                        ");
                        $categories[] = $this->database->getPDO()->lastInsertId();
                    }
                }

                else if ($key === 2) {
                    foreach($posts as $post) {
                        $randomCategories = $faker->randomElements($categories, 1);
                        foreach ($randomCategories as $category) {
                            $this->database->getPDO()->exec("INSERT INTO {$table} SET 
                                post_id = $post, 
                                category_id = $category
                            ");
                        }
                    }
                }

                else if ($key === 3) {
                    for ($i = 0; $i < 10; $i++) { 
                        $this->database->getPDO()->exec("INSERT INTO {$table} SET 
                            client = '{$faker->randomElement(["Pierre","Maria", "Meghan", "John"])}',
                            price = '{$faker->numberBetween(20, 50)}',
                            sold_at = '{$faker->date} {$faker->time}'
                        ");
                    }
                }
            }

            return $this;
        }
    }