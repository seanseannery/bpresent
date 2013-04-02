<?
class database_object
{

    protected $dbname
    protected $dbconn
    static protected $tablename
    static protected $field_list
  
    function database_object() {
        this->dbname = $DB_NAME;
    }

    function database_object( $table, $fields, $errors){
        $this->tablename = $table;
        $this->field_list = $fields;
        $this->error_list = $errors;
        
    }

    function select($where) {
        try{
            $select_sql = "SELECT " . implode(", ", array_keys($this->field_list)) . " FROM " . $this->tablename 
                            . "WHERE $where";

            return $this->dbconn->query($select_sql);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    function insert($values) {
        try{
            $insert_sql = "INSERT INTO $this->tablename (" . implode(", ", array_keys($values)) . 
                          ") VALUES (" . implode(", ", array_values($values)) . ")" ;

            $stmt = $this->dbconn->prepare($insert_sql);
            $stmt->execute();

        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    //creates the tables, mainly used in init scripts
    static function create_table() {
        try{
            var $create_sql = "CREATE TABLE IF NOT EXISTS " . $this->tablename . "( ";

            $out = array();
            foreach ($this->field_list as $name => $type) {
                 $out[] = "$name $type"
            }
            $create_sql .= implode(", ", $out) . ")";

            $this->dbconn->exec("$create_sql");
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    function connect() {
        try{
            // Create (connect to) SQLite database in file
            $this->dbconn = new PDO('sqlite:' . $this->dbname);
            // Set errormode to exceptions
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, 
                                    PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    function disconnect() {
        try{
            // Close file db connection
            $file_db = null
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }

    }



{
?>
