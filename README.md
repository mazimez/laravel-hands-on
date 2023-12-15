# Laravel Pint

In every project, irrespective of the language or framework employed, adherence to fundamental coding standards is crucial. This practice enhances project organization, fosters ease of comprehension, and facilitates collaboration. Coding standards encompass aspects such as appropriately naming folders and files, employing meaningful and standardized variable names, and formatting code for readability.

While poorly organized code may function correctly, it lacks maintainability and poses challenges when introducing new features. As a project expands, investing time in establishing and rigorously adhering to basic coding standards among your team becomes imperative. Various programming languages provide tools to enforce these standards. For instance, TypeScript and JavaScript have tools like `js prettier` and `ES lint`, while Laravel(PHP) offers a similar tool known as `Laravel Pint`. In this section, we will delve into how you can utilize `Laravel Pint` to apply coding standards to your projects.

## Description

`Laravel Pint` serves as a code style fixer designed to format your code according to specified standards. It allows customization to apply particular rules tailored to your project. Before delving into the details of `Laravel Pint`, it is advisable to establish rules collaboratively with your team. These rules may encompass naming conventions for folders and files, as well as guidelines for variable naming. Refer to [this documentation](https://cs.symfony.com/doc/rules/) for a comprehensive list of commonly used rules. Once the rules are decided, we can proceed with their application.

It's important to note that not every rule needs to be followed. The decision to adhere to specific rules is at your discretion, and different projects may warrant different rule sets. `Laravel Pint` allows for flexibility in excluding specific parts or files if certain rules cannot be applied for valid reasons. The primary goal is to ensure that your project adheres to rules that enhance team understanding and collaboration.

While `Laravel Pint` comes pre-installed with Laravel 10, if you are using an older version, you can obtain it by running the following command:

```bash
composer require laravel/pint --dev
```

Once installed, you can execute it using the command:

```bash
./vendor/bin/pint
```

## Files

1. [pint.json](pint.json): JSON file to configure `pint`.
2. `other files`: Updated by `pint` to fix formats.

## Getting Started

1. After installing `Pint`, run it with `./vendor/bin/pint`. This will scan your files for issues related to coding standards or rules you have set up. At the end, it will provide a list of files that have been updated, along with information about the updates (i.e., which rule prompted the update).

2. To decide which rules to apply, create a new JSON file [pint.json](pint.json) where you define all the necessary rules. It mainly consists of three parts: `preset`, `rules`, and `exclude`. Use `exclude` to ignore specific files and folders, similar to `.gitignore` for Git. For instance, include folders like `vendor`, `node_modules`, and `storage`; you can add any other folder as needed.

3. `preset` contains pre-defined rules suggested for particular use cases. Setting `preset` to `laravel` applies rules recommended by Laravel itself, aligning with the framework's components such as controllers, models, views, observers, migrations, etc. Other values for `preset` include `psr12`, `per`, and `symfony`. More information can be found on [pint's GitHub](https://github.com/laravel/pint/blob/main/resources/presets/laravel.php).

4. `rules` is where you can add extra rules not included in your `preset`, and you can also override any rules from here. For example, we override the rule `no_superfluous_phpdoc_tags` to false since we want to retain our PHPDoc tags. This is the space to include rules decided upon with your team. Refer to [this documentation](https://cs.symfony.com/doc/rules/) to find rules that best suit your needs.

5. Apply rules that enhance project understanding and collaboration; avoid unnecessary rules that do not contribute to project improvement.

## DIY (Do It Yourself)

Explore additional tasks:

- Consider creating custom rules for special logic that may be needed.
- Explore ways to ignore specific parts of your code from formatting or checking by `pint`.

## Additional Notes

- `Pint` aids in enhancing code readability and sometimes improves performance. Consider incorporating it into all your projects from the outset.
- Engage in insightful discussions with fellow developers by initiating new discussions on our [GitHub repository](https://github.com/mazimez/laravel-hands-on/discussions).
- Simplify interactions with developed APIs by utilizing our [Postman collection](https://elements.getpostman.com/redirect?entityId=13692349-4c7deece-f174-43a3-adfa-95e6cf36792b&entityType=collection).

## Additional Resources

1. [Laravel DOC for PINT](https://laravel.com/docs/10.x/pint)
2. [Configuring Laravel Pint](https://laravel-news.com/configuring-laravel-pint)
