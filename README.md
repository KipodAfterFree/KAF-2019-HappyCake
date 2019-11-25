# HappyCake

HappyCake is an information security challenge in the Web category, and was presented to participants of [KAF CTF 2019](https://ctf.kipodafterfree.com)

## Challenge story

Wish'em happy birthday!

## Challenge exploit

"Timing" (Failure depth) attack over the developer name.

## Challenge solution

No need

## Building and installing

[Clone](https://github.com/NadavTasher/2019-HappyCake/archive/master.zip) the repository, then type the following command to build the container:
```bash
docker build . -t happycake
```

To run the challenge, execute the following command:
```bash
docker run --rm -d -p 1050:80 happycake
```

## Usage

You may now access the challenge interface through your browser: `http://localhost:1050`

## Flag

Flag is:
```flagscript
KAF{12098421009713091723097120397428479354_ju5t_m3551n9_w1th_ya_b0ii}
```

## License
[MIT License](https://choosealicense.com/licenses/mit/)