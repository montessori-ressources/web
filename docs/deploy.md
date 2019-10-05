As a classic Symfony application it is needed to follow some steps to deploy the application on prod or test system. This page will help to list what we need to do.

Ideally once the codebase is on the system, we need to:

- update the DB if needed
- install package `composer install`
- deploy assets
  - Encore assets: `yarn encore production`


# Deploy on integration system

This app is setup to automatically deploy the `develop` branch on a Heroku application, using Travis CI. The setup is described [here](https://docs.travis-ci.com/user/deployment/heroku/).

If you want to manually deploy on Heroku a specific branch (`my-specific-branch`) you can do that by the following commands:

```
heroku git:remote -a heroku-app-name # add the heroku remote
git push heroku my-local-branch:master # push
```

# Deploy on prod

This app is setup to automatically deploy the `master` branch on the prod system, using Travis CI. The setup is using the file `deploy.sh` that is triggering all the needed actions (`git checkout` then `composer install`).
