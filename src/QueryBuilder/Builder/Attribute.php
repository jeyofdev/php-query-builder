<?php
    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Builder;


    use jeyofdev\Php\Query\Builder\Helpers\QueryBuilderHelpers;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Attributes\AbstractAttributes;
    use PDO;


    /**
     * Manage The attributes of PDO
     */
    class Attribute extends AbstractAttributes
    {
        /**
         * @var PDO
         */
        private $pdo;



        /**
         * @param PDO $pdo The connection to the database
         */
        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }



        /**
         * Set the value of an attribute
         *
         * @param  array  $attributes  
         * @return void
         */
        public function setAttribute (array $attributes = []) : void
        {
            if (!empty($attributes)) {
                foreach ($attributes as $key => $value) {
                    if (QueryBuilderHelpers::checkStringIsInArray($key, $this::ATTRIBUTES_ALLOWED)) {
                        $attribute = constant("PDO::ATTR_$key");

                        $name = "ATTRIBUTES_" . $key . "_ALLOWED";

                        if (QueryBuilderHelpers::checkStringIsInArray($value, $this->$name)) {
                            $value = constant("PDO::ATTR_$value");
                        }

                        $this->pdo->setAttribute($attribute, $value);
                    }
                }
            }
        }



        /**
         * Get the value of an attribute
         *
         * @param  string  $attribute  
         * @return integer
         */
        public function getAttribute (string $attribute) : int
        {
            $attribute = constant("PDO::ATTR_$attribute");
            return $this->pdo->getAttribute($attribute);
        }
    }