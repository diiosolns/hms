# hms
Hospital Management System


# Hoisting: Solving Folder display issue

## How to Fix It

### 1\. Using cPanel

If Namecheap uses **cPanel**, you can change the document root for your subdomain.

1.  Log in to your **Namecheap cPanel**.
2.  Find the **Subdomains** section under the **Domains** category.
3.  Locate your subdomain in the list.
4.  Next to the subdomain, there should be an option to change the **Document Root** or a pencil icon to edit it.
5.  Change the path from something like `/your_domain/subdomain_name` to `/your_domain/subdomain_name/public`.
6.  Save the changes.

### 2\. Editing the `.htaccess` File

If you don't have direct access to change the document root in cPanel, you can use the `.htaccess` file in your root folder.

1.  Connect to your server using an **FTP client** (like FileZilla) or the **cPanel File Manager**.
2.  Navigate to the root directory of your subdomain.
3.  Create or edit the `.htaccess` file and add the following code:
    ```apache
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteRule ^(.*)$ public/$1 [L]
    </IfModule>
    ```
4.  Save the file and upload it to the server.

### 3\. Modifying the `index.php` File

This is a less common but sometimes necessary method if the above two don't work.

1.  Navigate to the `public` directory of your Laravel project.
2.  Copy the `index.php` and `.htaccess` files from the `public` directory.
3.  Paste both files into the root directory of your subdomain.
4.  Open the `index.php` file in the root directory and modify the two paths at the top:
      * Find `$app = require_once __DIR__.'/../bootstrap/app.php';` and change it to `$app = require_once __DIR__.'/bootstrap/app.php';`.
      * Find `$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);` and change it to `$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);`.
      * *Note:* The changes depend on the path, so you might need to adjust them based on your folder structure. The key is to ensure they point to the correct files.
5.  Save the file.

After making these changes, clear your browser's cache and try to access the URL again. It should now load the Laravel home page instead of listing the directories.
================================================================