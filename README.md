##Developers
Connor Abdelnoor
##Date
March 27 2015

##Description
Shoe store app lets users create stores and brands which can be assigned to those stores.


##Use and Editing
To use the app, download the source code and run it in on your php server.
You will need to create a psql database. Open psql, create and enter a DB named shoes and run <br />
\i shoes.sql
You will need to create a psql database. Open psql, create and enter a DB named shoes_test and run <br />
\i shoes_test.sql
<br />
If those commands fail, create the databases manually. <br />
CREATE DATABASE shoes; <br />
\c shoes <br />
CREATE TABLE stores (id serial PRIMARY KEY, name varchar); <br />
CREATE TABLE brands (id serial PRIMARY KEY, name varchar); <br />
CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int); <br />
CREATE DATABASE shoes_test WITH TEMPLATE shoes; <br />
There is also the option to run the command \i shoes.sql once connected to the shoes database and run the command \i shoes_test.sql once connected to the shoes_test database.


To edit the app, download the source code and open it in your text editor. <br />
    *Note: If you are copying any of the code to your own directories, you may need to install Composer
    in your root directory.*

##Copyright (c) 2015 Connor Abdelnoor & Tommy Bountham
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
