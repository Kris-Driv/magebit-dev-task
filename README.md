# MageBit Developer Task

## Running

### back-end
By default it will use sqlite3 database. See `backend/config.php` to configure backend. (SQLite3 requires no setup)

To start serving, use php built-in server.
```
cd backend
php -S localhost:8000
```
To view emails listed in database, browse to that endpoint and it will serve you admin.php, or click [here](http://localhost:8000) 

**IMPORTANT:** front-end will expect backend to be on the port 8000.

### front-end
Built using VueJS <3

Latest application is pre-built in `dist` folder, however if you'd like to build it yourself, see bottom of this readme!

#### Using http-serve
```
cd dist
npx http-serve
```

### Using php built-in serve
```
cd dist
php -S localhost:8080
```

If You've done everything correctly and backend is running on port 8000. View the final product.
I've donated more time to this than I'd like to admit, and if there's any imperfections I'm okay with that, not planning any future updates unless critical issues appear.

## Build

```
npm run build
```

Will build ready to serve application in `~/dist` folder. 