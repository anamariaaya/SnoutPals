<?php

namespace Model;

class ActiveRecord{
     //Base de Datos
     protected static $db;
     protected static $columnsDB = [];
     protected static $table = '';
 
     //Errores - Validación
     protected static $alerts = [];
     
    
     //Definir la conexión a la BD
     public static function setDB($database){
         self::$db = $database;
     }

     // Setear un tipo de Alerta
    public static function setAlert($type, $message) {
        static::$alerts[$type][] = $message;
    }

    // Obtener las alerts
    public static function getAlerts() {
        return static::$alerts;
    }
    
    // Validación que se hereda en modelos
    public function validate() {
        static::$alerts = [];
        return static::$alerts;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultSQL($query) {
        // Consultar la base de datos
        $result = self::$db->query($query);
        // Iterar los resultados
        $array = [];
        while($registry = $result->fetch_assoc()) {
            $array[] = static::createObject($registry);
        }
        // liberar la memoria
        $result->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function createObject($registry) {
        $object = new static;

        foreach($registry as $key => $value ) {
            if(property_exists( $object, $key  )) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    public function attributes() {
        $attributes = [];
        foreach(static::$columnsDB as $column) {
            if($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizeAttributes() {
        $attributes = $this->attributes();
        $sanitized = [];
        foreach($attributes as $key => $value ) {
            $sanitized[$key] = self::$db->escape_string($value);
        }
        return $sanitized;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronize($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = trim($value);
          }
        }
    }

    // Registros - CRUD
    public function save() {
        $result = '';
        if(!is_null($this->id)) {
            // actualizar
            $result = $this->update();
        } else {
            // Creando un nuevo registro
            $result = $this->create();
        }
        return $result;
    }

    // Obtener todos los Registros
    public static function all() {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC";
        $result = self::consultSQL($query);
        return $result;
    }
    
    public static function allOrderBy($order){
        $query = "SELECT * FROM " . static::$table. " ORDER BY $order";
        
        $result = self::consultSQL($query);

        return $result;
    }

    public static function allByCol($col){
        $query = "SELECT $col FROM " . static::$table;
        
        $result = self::consultSQL($query);

        return $result;
    }
    public static function allOrderDesc($orden){
        $query = "SELECT * FROM " . static::$table. " ORDER BY $orden DESC";
        
        $result = self::consultSQL($query);

        return $result;
    }

    public static function allOrderAsc($orden){
        $query = "SELECT * FROM " . static::$table. " ORDER BY $orden ASC";
        
        $result = self::consultSQL($query);

        return $result;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$table  ." WHERE id = ${id}";
        $result = self::consultSQL($query);
        return array_shift( $result ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limit) {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id LIMIT ${limit}" ;
        $result = self::consultSQL($query);
        return $result;
    }

    // Busqueda Where con Columna 
    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE ${column} = '${value}'";
        //debugging($query);
        $result = self::consultSQL($query);
        return array_shift( $result );
    }

    // Busqueda Where con Columna 
    public static function whereAll($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE ${column} = '${value}'";
        //debugging($query);
        $result = self::consultSQL($query);
        return $result;
    }

    public static function whereOrdered($column, $value, $col) {
        $query = "SELECT * FROM " . static::$table . " WHERE ${column} = '${value}'". " ORDER BY ${col} ASC";
        $result = self::consultSQL($query);
        return $result;
    }

    public static function whereAdmin($column, $value, $value2) {
        $query = "SELECT * FROM " . static::$table . " WHERE ${column} = '${value}' OR ${column} = '${value2}'";
        $result = self::consultSQL($query);
        return $result;
    }

    public static function unionTables($table1, $table2){
        $query = "SELECT * FROM " . $table1 . " UNION SELECT * FROM " . $table2;
        $result = self::consultSQL($query);
        return $result;
    }

    public static function innerJoin($table1, $table2, $col1, $col2){
        $query = "SELECT ".$table1.".*". "FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 . "." . $col1 . " = " . $table2 . "." . $col2;
        $result = self::consultSQL($query);
        return $result;
    }

    public static function innerJoinWhere($table1, $table2, $col1, $col2){
        $query = "SELECT ".$table1.".*". "FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 . "." . $col1 . " = " . $table2 . "." . $col2 . " WHERE " . $table2 . $col2 . " = " . $col2;
        $result = self::consultSQL($query);
        return $result;
    }


    public static function innerJoinAll($table1, $table2, $col1, $col2){
        $query = "SELECT * FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 . "." . $col1 . " = " . $table2 . "." . $col2;
        $result = self::consultSQL($query);
        return $result;
    }
 
    //Crea un nuevo registro
    public function create() {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$table . " (";
        $query .= join(', ', array_keys($attributes));
        $query .= ") VALUES ('"; 
        $query .= join("', '", array_values($attributes));
        $query .= "')";

        //debugging($query); // Descomentar si no funciona algo

        // Resultado de la consulta
        $result = self::$db->query($query);
        return [
           'result' =>  $result,
           'id' => self::$db->insert_id
        ];
    }
 
    // Actualizar el registro
    public function update() {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Iterar para ir agregando cada campo de la BD
        $values = [];
        foreach($attributes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }
        //debugging($attributes);

        // Consulta SQL
        $query = "UPDATE " . static::$table ." SET ";
        $query .=  join(', ', $values );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        //debugging($query);
        // Actualizar BD
        $result = self::$db->query($query);
        return $result;
    }
 
     //Eliminar un registro
     public function delete(){        
         $query = "DELETE FROM ". static::$table ." WHERE id =".self::$db->escape_string($this->id)." LIMIT 1" ;
         $result = self::$db->query($query);
         return $result;
     }

     // Subida de archivos
     public function setImage($image){
         //Elimina la imagen previa
         if(!is_null($this->id)){
             $this->deleteImage();            
         }
         //Asignar el nombre de la imagen al atributo
         if($image){
             $this->image = $image;
         }
     }

     public function setDocument($document){
        //Elimina el documento previo
        if(!is_null($this->id)){
            $this->deleteDocument();            
        }
        //Asignar el nombre del documento al atributo
        if($document){
            $this->document = $document;
        }
    }
 
     //Eliminar la imagen
     public function deleteImage(){
         $existsFile = file_exists(IMAGES_FOLDER . $this->imagen);
             if($existsFile){
                 unlink(IMAGES_FOLDER . $this->imagen);
             } 
     }

     //Eliminar el archivo
     public function deleteDocument(){
        $existsDoc = file_exists(DOCS_FOLDER . $this->document);
        if($existsDoc){
            unlink(DOCS_FOLDER . $this->document);
        } 
    }
}