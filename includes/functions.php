<?php

/*------------------------------------------------Dinamic Selects----------------------------------*/

    // dinamic select -> display name is the same as value

    function dynamic_select($display_array, $element_name, $label = '', $init_value = '') {
        array_unshift($display_array, "");
        $menu = '';
        if ($label != '') $menu .= '
            <label for="'.$element_name.'">'.$label.'</label>';
        $menu .= '
            <select name="'.$element_name.'" id="'.$element_name.'">';
        if (empty($_REQUEST[$element_name])) {
            $curr_val = $init_value;
        } else {
            $curr_val = $_REQUEST[$element_name];
        }
        foreach ($display_array as $key => $value) {
            $menu .= '
                <option value="'.$value.'"';
            if ($key == $curr_val) $menu .= ' selected="selected"';
            $menu .= '>'.$value.'</option>';
        }
        $menu .= '
            </select>';
        return $menu;
    };

    // dinamic select 2: display name -> display_array, value -> value_array

    function dynamic_select_2($display_array, $value_array, $element_name, $label = '', $init_value = '') {
        array_unshift($display_array, "");
        array_unshift($value_array, 0);
        $menu = '';
        if ($label != '') $menu .= '
            <label for="'.$element_name.'">'.$label.'</label>';
        $menu .= '
            <select name="'.$element_name.'" id="'.$element_name.'">';
        if (empty($_REQUEST[$element_name])) {
            $curr_val = $init_value;
        } else {
            $curr_val = $_REQUEST[$element_name];
        }
        foreach ($display_array as $key => $value) {
            $menu .= '
                <option value="'.$value_array[$key].'"';
            if ($key == $curr_val) $menu .= ' selected="selected"';
            $menu .= '>'.$value.'</option>';
        }
        $menu .= '
            </select>';
        return $menu;
    };

/*------------------------------------------------DB queries----------------------------------*/

    // 1 dimension array query

    function db_1D_query($query){
        include 'connection.php';                                           // DB Connection 
        //echo $query;                                                      // query syntax 
	    $resul = mysqli_query($conn, $query, MYSQLI_USE_RESULT);            // DB QUERY
        $data_2D = mysqli_fetch_all($resul);                                // build data array
        $data_1D = array_reduce($data_2D, 'array_merge', array());          // complex array to 1 dimension array
    
        //print("<pre>".print_r($datos_test_2D,true)."</pre>");                       //  Debugging original array
        //print("<pre>".print_r($datos_test_1D,true)."</pre>");                       //  Debugging new array
        
        return $data_1D;
    };

    // insert query

    function db_insert_query($table,$fields,$values){
        include 'connection.php';
        $query = "INSERT INTO ".$table." ".$fields." VALUES ".$values;
		//echo $query;
		return mysqli_query($conn, $query);                        //inserts to db
    };

    // select query with 1 inner join and 1 where clause

    function db_select_1_inner_query($table1, $table2, $fields, $ONclause1, $whereClause){
        include 'connection.php';
        $query = "SELECT ".$fields." FROM ".$table1." INNER JOIN ".$table2." ON ".$ONclause1." WHERE ".$whereClause;
        //echo $query;
        return mysqli_query($conn, $query);                        //query to db
    };

    // select query with 2 inner joins and 1 where clause

    function db_select_2_inner_query($table1, $table2, $table3, $fields, $ONclause1, $ONclause2, $whereClause){
        include 'connection.php';
        $query = "SELECT ".$fields." FROM ".$table1." INNER JOIN ".$table2." ON ".$ONclause1." INNER JOIN ".$table3." ON ".$ONclause2." WHERE ".$whereClause;
		//echo $query;
		return mysqli_query($conn, $query);                        //query to db
    };

        // select query with 3 inner joins and 1 where clause

    function db_select_3_inner_query($table1, $table2, $table3, $table4, $fields, $ONclause1, $ONclause2, $ONclause3, $whereClause){
        include 'connection.php';
        $query = "SELECT ".$fields." FROM ".$table1." INNER JOIN ".$table2." ON ".$ONclause1." INNER JOIN ".$table3." ON ".$ONclause2." INNER JOIN ".$table4." ON ".$ONclause3." WHERE ".$whereClause;
        //echo $query;
        return mysqli_query($conn, $query);                        //query to db
    };


?>