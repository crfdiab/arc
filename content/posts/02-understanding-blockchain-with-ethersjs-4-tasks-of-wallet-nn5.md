+++
title = "02 Understanding Blockchain with ethersjs 4 Tasks of wallet"
author = "fangjun"
date = "2022-01-31T16:27:00Z"
description = "Ethersjs provides functions to deal with Ethereum blockchain wallet You can find Ethersjs"
tags = ["blockchain"," web3"," ethersjs"," dapp"]
slug = "/02-understanding-blockchain-with-ethersjs-4-tasks-of-wallet-nn5/"
+++
`Ethers.js` provides functions to deal with Ethereum blockchain wallet. You can find `Ethers.js` documents about Wallet [here](https://docs.ethers.io/v5/api/signer/#Wallet). 

Get a better understanding with the following tasks:

---

## Task 1: Create wallet from mnemonic and privateKey

#### Task 1.1 Create wallet from mnemonic
```js
mnemonic='myth like bonus scare over problem client lizard pioneer submit female collect'

//check whether it is valid mnemonic
ethers.utils.isValidMnemonic(mnemonic)

wallet = ethers.Wallet.fromMnemonic(mnemonic)
```

Note: You should never write your mnemonic and privateKey in your script like this, it's dangerous. 

The mnemonic and privateKey used here are the default ones used in `Ganache-cli` and are public. 

### Task 1.2 Address, Public key and Private key

```js
wallet.address
//'0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1'

wallet.privateKey
'0x4f3edf983ac636a65a842ce7c78d9aa706d3b113bce9c46f30d7d21715b23b1d'

wallet.publicKey
'0x04e68acfc0253a10620dff706b0a1b1f1f5833ea3beb3bde2250d5f271f3563606672ebc45e0b7ea2e816ecb70ca03137b1c9476eec63d4632e990020b7b6fba39'
```

This is the address with path "m/44'/60'/0'/0/0".

We can also get mnemonic of wallet if it is created from mnemonic.

```js
wallet.mnemonic
{
  phrase: 'myth like bonus scare over problem client lizard pioneer submit female collect',
  path: "m/44'/60'/0'/0/0",
  locale: 'en'
}
```

### Task 1.3 Create wallet from privateKey

We can also create wallet from privateKey. Wallet created in this way has no mnemonic property.
```js
privateKey='0x4f3edf983ac636a65a842ce7c78d9aa706d3b113bce9c46f30d7d21715b23b1d'
wallet = new ethers.Wallet(privateKey)

wallet.address
//'0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1'
wallet.mnemonic
//null
```

---


## Task 2: create 20 addresses with mnemonic

We will use `Ethers.js` utility for [HD Wallet (HDNode)](https://docs.ethers.io/v5/api/utils/hdnode/#hdnodes) to do this.

### Task 2.1 Create HDNode instance from mnemonic
```js
mnemonic='myth like bonus scare over problem client lizard pioneer submit female collect'

hdnode = ethers.utils.HDNode.fromMnemonic(mnemonic)
```

### Task 2.2 Get 20 addresses 

```js
basepathstr = "m/44'/60'/0'/0/"
for(i=0;i<20;i++){console.log(hdnode.derivePath(basepathstr+i.toString()).address)}
```

result:

```
0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1
0xFFcf8FDEE72ac11b5c542428B35EEF5769C409f0
0x22d491Bde2303f2f43325b2108D26f1eAbA1e32b
......
```

The first is with path: "m/44'/60'/0'/0/0"
The second is with path: "m/44'/60'/0'/0/1"
The third is with path: "m/44'/60'/0'/0/2"

### Task 2.3 Get address with path

We can also get wallet address with path.

```js
mnemonic='myth like bonus scare over problem client lizard pioneer submit female collect'

wallet = ethers.Wallet.fromMnemonic(mnemonic,"m/44'/60'/0'/0/1")
wallet.address
//'0xFFcf8FDEE72ac11b5c542428B35EEF5769C409f0'
```

---

## Task 3: Sign message with wallet

### Task 3.1: Prepare wallet as a signer

```js
mnemonic='myth like bonus scare over problem client lizard pioneer submit female collect'
wallet = ethers.Wallet.fromMnemonic(mnemonic,"m/44'/60'/0'/0/1")
```

### Task 3.2: sign message
```js
message = "solidity-class"
sig = await wallet.signMessage(message)
//'0x8637dce5aeb0b9bd9ee8ce909252806ede88eebc3789436f8f569dd1e45f3f2b47e6633d4119c26917e4b2e08c422028df2209a8ca401f77d4aab9f24b6a40831b'
```

The signature is result to signing: "\x19Ethereum Signed Message:\n" + message.length + message. [Ethers.js docs](https://docs.ethers.io/v5/api/signer/#Signer-signMessage) explains:
> A signed message is prefixd with "\x19Ethereum Signed Message:\n" and the length of the message, using the hashMessage method, so that it is EIP-191 compliant. If recovering the address in Solidity, this prefix will be required to create a matching hash.

### Task 3.3: verify message

```js
ethers.utils.verifyMessage(message,sig)
//'0xFFcf8FDEE72ac11b5c542428B35EEF5769C409f0'
```

### Task 3.4: sign message hash 

We can hash the message by ourselves and sign messagehash instead. We got the same signature.

```js
messageHash=  ethers.utils.hashMessage(message)
sig = await wallet.signMessage(messageHash)
//'0xfc40fcec036bd4501ce3bfaf991d561553db6d3601702f8abed9f733eab31a5246163711f71ad48b002ddf83c7cd93656047759ab8e2ff4420c59d5845680ca11b'
```

### Task 3.5 Understanding signature

Get the r,s,v of the signature which is r+s+v.

```js
const r = sig.slice(0, 66);
const s = '0x' + sig.slice(66, 130);
const v = '0x' + sig.slice(130, 132);
```

---

## Task 4: Send transaction from wallet

### Task 4.1 Create wallet 

```js
// get wallet account not in hardhat default
privateKey='0x4f3edf983ac636a65a842ce7c78d9aa706d3b113bce9c46f30d7d21715b23b1d'
wallet = new ethers.Wallet(privateKey)

wallet.address
//'0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1'

wallet.provider
//null
```

### Task 4.2 send ethers from account 0 to test account

You can send Test Ethers to test wallet address for gas fee usage using MetaMask. 

Or you can do it in the console as we do in previous part of this tutorial:

```js
signer = await ethers.provider.getSigner()
send_address = await signer.getAddress()

to_address = wallet.address
nonce = await signer.getTransactionCount()
gas_price = await signer.getGasPrice()
gas_limit = ethers.utils.hexlify(21000)
value = ethers.utils.parseUnits('100.0')

tx = {
  from: send_address,
  to: to_address,
  value: value,
  nonce: nonce,
  gasLimit: gas_limit,
  gasPrice: gas_price,
}

await signer.sendTransaction(tx)

await ethers.provider.getBalance(wallet.address).then(result=>ethers.utils.formatEther(result))
//'100.0'
```

### Task 4.3 Try to send from wallet wrongly

Let us try to call sendTransaction from signer which is different with the `send_address`.

```js
send_address = wallet.address

to_address = await signer.getAddress()
nonce = await signer.getTransactionCount()
gas_price = await signer.getGasPrice()
gas_limit = ethers.utils.hexlify(21000)
value = ethers.utils.parseUnits('1.0')

tx = {
  from: send_address,
  to: to_address,
  value: value,
  nonce: nonce,
  gasLimit: gas_limit,
  gasPrice: gas_price,
}

await signer.sendTransaction(tx)
```
We got an Error: "Error: from address mismatch".

### Task 4.4 Send from wallet - connect wallet to get signer

First, connect wallet to provider. The return of `connect()` is the wallet instance which can be a signer.

```js
walletsigner = await wallet.connect(ethers.provider)
walletsigner.address
//'0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1'
```

### Task 4.4 Send ETH using wallet as a signer

Second, `sendTransaction` with walletsigner:

```js
to_address = await signer.getAddress()
nonce = await walletsigner.getTransactionCount()
gas_price = await signer.getGasPrice()
gas_limit = ethers.utils.hexlify(21000)
value = ethers.utils.parseUnits('1.0')

tx = {
  from: send_address,
  to: to_address,
  value: value,
  nonce: nonce,
  gasLimit: gas_limit,
  gasPrice: gas_price,
}

await walletsigner.sendTransaction(tx)

await ethers.provider.getBalance(wallet.address).then(result=>ethers.utils.formatEther(result))
//'98.999968220292873'
```

---

If you find this note useful, please follow my twitter [@fjun99](https://twitter.com/fjun99).

---