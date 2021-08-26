CURRENT_BRANCH="$(git symbolic-ref HEAD 2>/dev/null)" ||
CURRENT_BRANCH="(unnamed branch)"     # detached HEAD
CURRENT_BRANCH=${CURRENT_BRANCH##refs/heads/}

if [ "$CURRENT_BRANCH" == "8.x-9.x" ]    # ← see 'man test' for available unary and binary operators.
then
    OTHER_BRANCH="8.9.x"
    CURRENT_ORIGIN="origin"
    OTHER_ORIGIN="github"
else
    OTHER_BRANCH="8.x-9.x"
    CURRENT_ORIGIN="github"
    OTHER_ORIGIN="origin"
fi


git commit -m "$1" --author="$2"
git push $CURRENT_ORIGIN $CURRENT_BRANCH
git checkout $OTHER_BRANCH
git merge $CURRENT_BRANCH --no-edit
git push $OTHER_ORIGIN $OTHER_BRANCH
git checkout $CURRENT_BRANCH
