#!/usr/bin/env bash

for i in {12..1}; do
  COMMIT=master~${i}
  git checkout ${COMMIT} --quiet -- ./
  read -p "$(git log --format=%s -n 1 ${COMMIT})"
  git checkout ${COMMIT} --quiet --force
done

git log --format=%s -n 1 master
git checkout master --quiet
