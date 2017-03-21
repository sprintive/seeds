core = 8.x
api = 2

includes[] = drupal-org.make

; Download the Seeds install profile and recursively build all its dependencies:
projects[seeds][type] = profile
projects[seeds][download][type] = git
projects[seeds][download][branch] = 8.x-1.x-dev
projects[seeds][download][url] = git@bitbucket.org:sprintive/seeds.git