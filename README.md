# Conditional Article Block Module

## Overview

The **Conditional Article Block** module provides a custom block that appears on **Article** pages only if a site configuration setting is enabled. This setting can be toggled in the **Site Information** form.

## Features

* Adds a custom checkbox in the Site Information form to enable or disable the custom block.
* Displays a custom block on Article nodes only when the checkbox is enabled.
* Provides proper caching strategies using cache contexts and cache tags.

---

## Installation Instructions

### 1. Download and Enable the Module

* Download the module and place it in the `modules/custom/` directory of your Drupal site.
* Enable the module using Drush:

  ```bash
  drush en conditional_article_block
  ```
* Clear the site cache:

  ```bash
  drush cr
  ```

### 2. Configure the Module

* Go to **Configuration > System > Basic Site Settings (admin/config/system/site-information)**.
* You will see a new checkbox option **"Display Custom Block on Article pages"**.
* Enable this checkbox to allow the custom block to appear on Article nodes.

### 3. Add the Block to the Layout

* Go to **Structure > Block Layout (admin/structure/block)**.
* Locate the **"Article Custom Block"**.
* Place this block in the region.
* Save the block placement.

---

## Caching Strategy

### 1. Cache Contexts

* The block uses a **"route"** cache context, ensuring that it is cached based on the current route.
* This ensures that the block is only displayed on Article pages as intended.

### 2. Cache Tags

* The block is tagged with **"config**\*\*:system\*\*\*\*.site"\*\*.
* This allows the block cache to be cleared when the Site Information configuration is updated.

### 3. Cache Invalidation

* Whenever the checkbox in the Site Information form is toggled, the cache tag **"config**\*\*:system\*\*\*\*.site"\*\* is invalidated.
* This ensures that the block visibility is updated immediately after configuration changes.
