# Table of contents

1. [The project](#project)
2. [What is a dependency injection container](#container)
   1. [Which problems it try to solve](#problems)
   1. [What is dependency injection](#dependency-injection)
3. [Another paragraph](#paragraph2)

<a name="project"></a>

## The Project

This is a small dependency injection container builded from scratch for educational purpose. If you are an Obect Oriented enthusisat or if you are interested in concepts behind software developement in general, read the the doc i am going to dissect the code and try my best to explain all the notions envolved in this project.

<a name="container"></a>

## What is a dependency injection container

A dependency injection container is not business domain related. It rather serve as a mechanisms for the environement in which your application will evolve. You can find them in some framework like Symfony. You can think of it as a big array that will help you and your team manage all your abjects in your application.

<a name="problems"></a>

### Which problems it try to solve

As your application get bigger you will need to manage more an more objects. This object may also depende on other object to function through **dependecy injection**. If you are unfamiliar with this notion i suggest that you stop here for a moment and read first [What is dependency injection](#dependency-injection) or check it up from an other source. Fabien potencier explain it very well in his blog [here](http://fabien.potencier.org/what-is-dependency-injection.html)

<a name="dependency-injection"></a>

### What is dependency injection

It is an Object Oriented design pattern
