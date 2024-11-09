# phalanx

The backend for authoring Dauntless Builder data

## Setup

For our supported setup you'll need [Docker](https://docs.docker.com/engine/install/) and [DDEV](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/) installed and configured.

```bash
# clone the project
$ git clone https://github.com/atomicptr/phalanx.git
$ cd phalanx

# starts the project
$ ddev start

# create secret
$ ddev artisan key:generate

# next we are setting up the DB...

# (OPTIONAL) if you have a dump (ask or remind me to offer a dump somewhere) you can do this:
$ ddev import-db < my-dump.sql

# Otherwise, lets create a new DB...
$ ddev artisan migrate

# we also need to create a user (this command spawns a PHP REPL)
$ ddev artisan tinker
#     $user = new \App\Models\User;
#     $user->email = "your@email.com";
#     $user->password = Hash::make("your-password");
#     $user->save();
#     exit();

# run the build process (perhaps in a different shell...)
$ ddev watch
```

Phalanx should now be available at https://phalanx.ddev.site (the HTTPS certificate might be invalid if you haven't setup mkcert properly)

If you created a new database, don't forget to first setup a Patch.

## License

AGPLv3
