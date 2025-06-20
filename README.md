# Negeka_PageCacheWarm

A **page cache warming module** developed for Magento 2. It sends `cURL` requests to the URLs you define, warming up the page cache and preventing slow loading on the first user visit.

---

## Installation

You can install the module by following these steps:

1. Place the module files into the folder:  
   `app/code/Negeka/PageCacheWarmer`  
 
2. Enable Module:  
   ```
   php bin/magento module:enable Negeka_PageCacheWarmer
   ```
3. Run compilation commands
```
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
```
## How to Use?

1. **Go to Settings in the Admin Panel:**  
   Navigate to `Stores > Configuration > Page Cache Warmer`.

2. **Enter the URLs:**  
   In the "URL list" field, enter the URLs you want to warm the cache for, **separated by commas**.  
   Example:
  ```
  https://app.exampleproject.test/women.html,
  https://app.exampleproject.test
  ```

3. **Save the Configuration:**  
Click the **Save Config** button at the top right of the page.

4. **Clean the Config Cache:**  
Run the following command to clean the configuration cache:  
```bash
php bin/magento cache:clean config
```
5. Use the Warm Cache Button:
Go back to Stores > Configuration > Page Cache Warmer and click the Warm Cache button at the bottom of the page.

6. Cache Warming Starts:
The module will send requests to the URLs you entered, warm their caches, and display success or failure messages accordingly.


