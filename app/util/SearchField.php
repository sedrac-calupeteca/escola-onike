<?php

namespace App\Util;

class SearchField{

    public static function user(){
        return (object)[
            "fields" => [
                'name' => 'Nome', 
                'email' => 'Email', 
                'bilhete_identidade' => 'Bilhete Identifição',
                'data_nascimento' => 'Data nascimento'
            ]
        ];
    }

    public static function anolectivo(){
        return (object)[
            "fields" => [
                'codigo' => 'Código',  
                'data_inicio' => 'Data inicio',
                'data_fim' => 'Data final',
                'descricao' => 'Descrição',
            ]
        ];
    } 
    
    public static function prova(){
        return (object)[
            "fields" => [
                'simestre' => 'Simestre',  
                'tipo' => 'Tipo',
                'professor' => 'Professor',
                'disciplina' => 'Disciplina',
                'curso' => 'Curso',
            ]
        ];
    }     

    public static function calendario(){
        return (object)[
            "fields" => [
                'simestre' => 'Simestre',  
                'tipo' => 'Tipo',
                'data_inicio' => 'Data inicio',
                'data_fim' => 'Data final',
                'codigo' => 'Código',
                'descricao' => 'Descrição',
            ]
        ];
    } 
    
    public static function reuniao(){
        return (object)[
            "fields" => [
                'nome' => 'Titulo',  
                'data_inicio' => 'Data inicio',
                'data_fim' => 'Data final',
                'descricao' => 'Descrição',
            ]
        ];
    }    
    
    public static function curso(){
        return (object)[
            "fields" => [
                'nome' => 'Nome',  
                'num_classe' => 'Classe',
                'nivel' => 'Nível',
            ]
        ];
    }    
    
    public static function disciplina(){
        return (object)[
            "fields" => [
                'nome' => 'Nome',
                'descricao' => 'Descrição',
            ]
        ];
    }   
    
    public static function turma(){
        return (object)[
            "fields" => [
                'curso' => 'Curso',
                'periodo' => 'Período',
                'anolectivo' => 'Ano lectivo',
            ]
        ];
    }    

}