#!/bin/bash
set -e

cd "$(dirname "$(readlink -f "$BASH_SOURCE")")"

versions=( "$@" )
if [ ${#versions[@]} -eq 0 ]; then
	versions=( */ )
fi
versions=( "${versions[@]%/}" )


for version in "${versions[@]}"; do
	fullVersion="$(curl -sSL "http://ftp.osuosl.org/pub/mariadb/repo/$version/ubuntu/dists/trusty/main/binary-amd64/Packages" | iconv -f utf-8 | grep -m1 -A10 "^Package: mariadb-server\$" | grep -m1 '^Version: ' | cut -d' ' -f2)"
	(
		set -x
		rm "$version"/*
		cp init.sh run.sh wait.sh Dockerfile.template "$version/"
		chmod +x "$version"/*.sh
		mv "$version/Dockerfile.template" "$version/Dockerfile"
		sed -i 's/%%MARIADB_MAJOR%%/'$version'/g; s/%%MARIADB_VERSION%%/'$fullVersion'/g' "$version/Dockerfile"
	)
done
