<?php

// Using own PHP Class to parse JSON to detect errors

class Json {

    /**
     * Decode JSON String and check for errors
     *
     * @static
     * @param string $instr The json string being decoded
     * @param bool $asArray When TRUE, returned objects will be converted into associative arrays.
     * @return mixed
     */

    public static function decode( $instr, $asArray = true ) {
        $decoded = @json_decode( $instr, $asArray );
        self::checkError();
        return $decoded;
    }

    /**
     * Encode Data to JSON and check for errors
     *
     * @static
     * @param mixed $data The value being encoded. Can be any type except a resource.
     * @return string
     */

    public static function encode( $data ) {
        $encoded = @json_encode( $data );
        self::checkError();
        return $encoded;
    }

    /**
     * Function to check for json_* errors, because the results is
     * unrealiable in PHP
     *
     * json_decode returns null on failure, but null is also a valid json value
     * json_encode returns false on failure, but false is also a valid json value
     *
     * @static
     * @throws Exception
     */

    private static function checkError() {

        $msg = false;
        switch ( json_last_error() ) {
            case JSON_ERROR_DEPTH:          $msg = 'Maximum stack depth exceeded';          break;
            case JSON_ERROR_STATE_MISMATCH: $msg = 'Underflow or the modes mismatch';       break;
            case JSON_ERROR_CTRL_CHAR:      $msg = 'Unexpected control character found';    break;
            case JSON_ERROR_SYNTAX:         $msg = 'Syntax error, malformed JSON';          break;
            case JSON_ERROR_UTF8:           $msg = 'Malformed UTF-8';                       break;
        }

        if( $msg ) {
            throw new Exception( 'JSON Error: '. $msg );
        }

    }

}
