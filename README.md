# Table of contents

1. [Introduction](#introduction)
2. [What is dependency injection](#dependency-injection)
3. [What is a dependency injection container](#container)
4. [Which problems it try to solve](#problems)

<a name="introduction"></a>

## Introduction

This is a small dependency injection container built from scratch for educational purpose. I am going to write this documentation like a blog post. If you are an Obect Oriented enthusiast or if you are interested in the concepts behind software development in general, keep reading, I will try my best to explain all the notions involved in this project.

Please be aware that I do not have yet a strong background in software development. This documentation refers only to my personal understanding and is subject to errors. I hope you will pick up something useful from this.

<a name="dependency-injection"></a>

## What is dependency injection

When we talk about class, a dependency is a term that refers to an object which another object depends on to carry its work.

Making an object delegate to others objects a task that is out of its scope is good sign that you are honoring the Single Responsibility Principle.
The degree of dependence between this object is call coupling.

First illustration with inheritance :

```php
class Human extends Biped
{
}
```

The subclass Human above is derived from its parent Biped. Human is strongly tight to it's parent.

Second illustration with composition :

```php
class Human
{
   private $biped;

   public function __constructu()
   {
      $this->biped = new Biped();
   }
}
```

Here we also have a strongly tight coupling.

Imagine a scenario where Biped is a third party library and the author makes an upgrade. I might have to modify the class Human and therefore violate the Open Close Principle.

Biped is also a hidden dependency, we need to have access to the source code of Human to discover that it is using Biped.

Dependency Injection is an Object Oriented Design pattern that will help you if you are in a situation where you do not want your class to be responsible for the creation of its dependency.

The implementation is not complicated, you get the dependency from outside as a parameter and pass it through the constructor or via a setter.

```php
class Human
{
   private $biped;

   public function __construct(Biped $biped)
   {
      $this->biped = $biped;
   }
}

$biped = new Biped;
$human = new Human($biped);
```

- Now the code is more readable, the dependency is not hidden
- You have more flexibility, you can change the dependency it is not hardcoded in the class
- Both classes can be tested independently

<a name="container"></a>

## What is a dependency injection container

A dependency injection container is not business domain related. It rather serves as a mechanism for the environment in which your application will evolve. You can find them in frameworks.

<a name="problems"></a>

## Which problems can be solved with the container

You and your team developed classes that are well defined and you are using [**dependecy injection**](#dependency-injection) to connect them together. But the application gets bigger and you need to keep track of all the subsystems plus you also need to handle their dependencies.
