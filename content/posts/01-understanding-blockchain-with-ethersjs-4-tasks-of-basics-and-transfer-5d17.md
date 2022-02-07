+++
title = "01 Understanding Blockchain with ethersjs 4 Tasks of Basics and Transfer"
author = "fangjun"
date = "2022-01-31T16:23:45Z"
description = "As a web3 developer you can play with Ethereum blockchain using Ethersjs to get a deeper"
tags = ["blockchain"," web3"," ethersjs"," dapp"]
slug = "/01-understanding-blockchain-with-ethersjs-4-tasks-of-basics-and-transfer-5d17/"
+++
As a web3 developer, you can play with Ethereum blockchain using `Ethers.js` to get a deeper understanding. This 3-parts tutorial lists 12 tasks for you.

`Ethers.js` is a Javascript API for Ethereum blockchain which can work with Mainnet, testnet such as Ropsten, Rinkeby, local testnet, Layer 2 and sidechains. 

We will use Hardhat Ethereum development environment to set up a playground as it can provide all the components we need: 

- local testnet: Hardhat Network based on `@ethereumjs/vm`
- interactive console: Hardhat console
- solidity development tools: Hardhat
- ethers.js: Ethereum Javascript API

Hardhat brings in `ethers.js` with plugin `hardhat-ethers`.

Ethers.js documents: https://docs.ethers.io/v5/ 

---

## Task 1: Setup ethers.js playground with Hardhat

You need to have `node.js` and `yarn` installed in your computer.

### Task 1.1 Install Hardhat

Run in command line:
```
mkdir playeth && cd playeth
yarn add hardhat
```

### Task 1.2 Init Hardhat project

You can init a Hardhat project by running: 
```
yarn hardhat 
```

Choose Option "Create an advanced sample project that uses TypeScript". A sample hardhat project will be created.

### Task 1.3 Run a stand-alone local testnet

In another terminal, run a stand-alone local testnet "Hardhat Network" by running: 

```
yarn hardhat node
```

More about in-process and stand-alone mode of Hardhat Network can be found [here](https://hardhat.org/hardhat-network/#how-does-it-work).

### Task 1.4 Enter Hardhat console

Run Hardhat console connecting to blockchain testnet localhost:

```
yarn hardhat console --network localhost
```

Check `ethers.js` version and get the current blocknumber in console:
```js
ethers.version
//'ethers/5.5.3'

await ethers.provider.getBlockNumber()
//0
```

Now, you have an ethers.js playground with an interactive console and a local testnet.

---

## Task 2: Have a look at blockchain

Currently Hardhat console is connected to a local blockchain testnet at http://localhost:8545. Let's have a look at the blockchain with `Ethers.js`. 

`Ethers.js` provide "Provider" and "Signer" for interaction with blockchain. Its document explains: 

- A [Provider](https://docs.ethers.io/v5/api/providers/provider/) in ethers is a read-only abstraction to access the blockchain data.

- A [Signer](https://docs.ethers.io/v5/api/signer/) in ethers is an abstraction of an Ethereum Account, which can be used to sign messages and transactions and send signed transactions to the Ethereum Network to execute state changing operations.

### Task 2.1 check connection

We can access provider `ether.provider`,a ethers.js wrapped Ethereum RPC provider.

```js
const provider = ethers.provider
ethers.provider.connection
// { url: 'http://localhost:8545' }
```

### Task 2.2 check network of provider 

```js
await provider.getNetwork()
//{ chainId: 31337, name: 'unknown' }
```

Ethereum network with chainId 31337 is local testnet at `127.0.0.1:8545`.

### Task 2.3 get signer

The big diffence between `ethers.js` and `web3.js` is that it seperate signer from provider. Provider can only read data from blockchain while signer can send transactions to change data on blockchain. Ethers.js docs explain signer:

```js
const signer = await provider.getSigner()
//this is a JsonRpcSigner

await signer.getAddress()
//'0xf39Fd6e51aad88F6F4ce6aB8827279cffFb92266'
```

### Task 2.4 get all the accounts with Hardhat console

Hardhat console is running with 20 test accounts.

```js
accounts = await ethers.getSigners();
accounts.length
//20

for (const account of accounts) console.log(account.address)

Result: 
0xf39Fd6e51aad88F6F4ce6aB8827279cffFb92266
0x70997970C51812dc3A010C7d01b50e0d17dc79C8
0x3C44CdDdB6a900fa2b585dd299e03d12FA4293BC
0x90F79bf6EB2c4f870365E785982E1f101E93b906
...
```

There is a sample hardhat plugin `accounts`, you can run it in command line:

```
yarn hardhat accounts
```

---

## Task 3: Get ETH balance of an address

We can use `getBalance()` to get ETH balance of an address ([reference link](https://docs.ethers.io/v5/api/providers/provider/#Provider-getBalance)). Since we only need to read data from blockchain, we will use `provider` instead of `signer`.

### Task 3.1 getBalance

```js
firstaddress = accounts[0].address
balance = await provider.getBalance(firstaddress)
//BigNumber { value: "10000000000000000000000" }
```

The return result is BigNumber, which means 10000.0 ethers. Every accountshave 10000.0 test ethers in Hardhat local testnet. 

### Task 3.2 formatEther

We can use ethers.js utilities for [Display Logic and Input](https://docs.ethers.io/v5/api/utils/display-logic/) to display it in a friendly manner.

```js
ethers.utils.formatEther(balance)
//'10000.0'
```

### Task 3.3 parseEther

We can also transfer from string to Bignumber easily.

```js
ethers.utils.parseEther("0.5");
//BigNumber { value: "500000000000000000" }
```

---

## Task 4: Send ETH from one address to another

### Task 4.1 Send ETH using MetaMask
You can use MetaMask to transfer test ethers between accounts:

1. Switch network to Localhost8545 in MetaMask
2. Import account #0 with privateKey
3. Transfer 100 test ETH from Account #0 to Account #1
  
```js
Accounts #0: 0xf39Fd6e51aad88F6F4ce6aB8827279cffFb92266
privateKey: 0xac0974bec39a17e36ba4a6b4d238ff944bacb478cbed5efcae784d7bf4f2ff80 
Accounts #1: 0x70997970C51812dc3A010C7d01b50e0d17dc79C8
```

Address #00 and privateKey to add account to MetaMask. Address #1 is the receiver.

Note: Remember to change chainId from "1337" to "31337" in MetaMask network setting.

You can check the results in console:

```js
provider = ethers.provider
acccount_1='0x70997970C51812dc3A010C7d01b50e0d17dc79C8'
await provider.getBalance(acccount_1).then((r)=>console.log(ethers.utils.formatEther(r)))
//'10100.0'
```

Send ETH from one address to another can be done by call `sendTransaction` using Ethers.js. Related Ether.js docs is [here](https://docs.ethers.io/v5/api/providers/provider/#Provider-sendTransaction). 

Detailed explanation of Transaction can be found in  Andreas M. Antonopoulos's book [Mastering Etereum Chapter 6 Transactions](https://github.com/ethereumbook/ethereumbook/blob/develop/06transactions.asciidoc).  

### Task 4.2 Prepare for sendTransaction

```js
signer = await ethers.provider.getSigner()
send_address = await signer.getAddress()

accounts = await ethers.getSigners();
to_address = accounts[1].address

nonce = await signer.getTransactionCount()
gas_price = await signer.getGasPrice()
gas_limit = ethers.utils.hexlify(21000)

value = ethers.utils.parseUnits('100.0')
```

### Task 4.3 Format transaction

```js
tx = {
  from: send_address,
  to: to_address,
  value: value,
  nonce: nonce,
  gasLimit: gas_limit,
  gasPrice: gas_price,
}
```

### Task 4.4 Call `sendTransaction`

Send transaction: 
```js
await signer.sendTransaction(tx)
```

### Task 4.5 Check results

```js
provider = ethers.provider
await provider.getBalance(to_address).then((r)=>console.log(ethers.utils.formatEther(r)))
//'10200.0'
await provider.getBalance(send_address).then((r)=>console.log(ethers.utils.formatEther(r)))
//'9799.999923543659375'
```

The balance of send_address is a little less than 9800.0 because it paid some ether as gas fee for the transactions.

When `sendTransaction` called, it returns receipt of the transaction executed on the blockchain. 
```json
{
  hash: '0x8915f9df88e4f2af2eefe05922e026c66723678b7df3de11e525a03c11b391a2',
  type: 0,
  accessList: null,
  blockHash: '0xfae5411b597d02b1c36a6842f14db5aad7ac2b974474f06355bd1b4eb5d438ed',
  blockNumber: 1,
  transactionIndex: 0,
  confirmations: 1,
  from: '0xf39Fd6e51aad88F6F4ce6aB8827279cffFb92266',
  gasPrice: BigNumber { value: "1875000000" },
  gasLimit: BigNumber { value: "135168" },
  to: '0x70997970C51812dc3A010C7d01b50e0d17dc79C8',
  value: BigNumber { value: "100000000000000000000" },
  nonce: 0,
  data: '0x',
  r: '0x116a4e2acba174b04a6f44248fef0170012d956d20e03d93b1b3368fce09c8e8',
  s: '0x14f1104a1fa98fed53a06a4a7a6464503d1f8a822191c022a2180e45c258809b',
  v: 62710,
  creates: null,
  chainId: 31337,
  wait: [Function (anonymous)]
}
```

You can also have a look at the termial running `yarn hardhat node`. Transaction details are logged on the screen:

```
  Transaction: 0x8915f9df88e4f2af2eefe05922e026c66723678b7df3de11e525a03c11b391a2
  From:        0xf39fd6e51aad88f6f4ce6ab8827279cfffb92266
  To:          0x70997970c51812dc3a010c7d01b50e0d17dc79c8
  Value:       100 ETH
  Gas used:    21000 of 135168
  Block #1:    0xfae5411b597d02b1c36a6842f14db5aad7ac2b974474f06355bd1b4eb5d438ed
```

---

If you find this note useful, please follow my twitter [@fjun99](https://twitter.com/fjun99).

---