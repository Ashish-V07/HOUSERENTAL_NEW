    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #0c0c0c;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        .form-inline {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .form-inline .form-group {
            flex: 1;
            margin-right: 10px;
        }
        .form-inline .form-group:last-child {
            margin-right: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group .radio-group {
            display: flex;
            align-items: center;
        }
        .form-group .radio-group input {
            margin-right: 5px;
        }
        .form-group .radio-group label {
            margin-right: 20px;
        }
        .form-group #timer {
            font-size: 18px;
            color: red;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }
        .form-actions input {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .form-actions input:hover {
            background-color: #0056b3;
        }
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #f44336;
            color: #fff;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

