+++
title = "03 Understanding Blockchain with ethersjs 4 Tasks of interacting with smart contract"
author = "fangjun"
date = "2022-01-31T16:28:04Z"
description = "In third part of this ethersjs tutorial we will use ethersjs to interact with smart"
tags = ["blockchain"," web3"," ethersjs"," dapp"]
slug = "/03-understanding-blockchain-with-ethersjs-4-tasks-of-interacting-with-smart-contract-3ef6/"
+++
In third part of this `ethers.js` tutorial, we will use `ethers.js` to interact with smart contract.

What we do here is a little beyond the scope of learning `ethers.js`:

- Write a ERC20 token smart contract with OpenZeppelin
- Deploy the smart contract to Hardhat local testnet
- Interact with smart contract using `Ethers.js`

---

## Task 1: Write ERC20 token smart contract

We will write an ERC20 token smart contract using the verified and popular solidity token library [OpenZeppelin](https://docs.openzeppelin.com/contracts/4.x/).

### Task 1.1 Install OpenZeppelin

In the hardhat project directory, install OpenZepplin:

```
yarn add @openzeppelin/contracts
```

### Task 1.2 Write smart contract in Solidity

There is a "Greeter.sol" and related test script "test/index.ts" and deploy script "scripts/deploy.ts" in the project. We will leave them there.

Add "contracts/classtoken.sol"
```solidity
//SPDX-License-Identifier: Unlicense
pragma solidity ^0.8.0;

import "@openzeppelin/contracts/token/ERC20/presets/ERC20PresetMinterPauser.sol";

contract ClassToken is ERC20PresetMinterPauser {
        constructor(uint256 initialSupply) ERC20PresetMinterPauser("ClassToken", "CLT") {
        _mint(msg.sender, initialSupply);
        }
}
```

We create an ERC20 token smart contract which inherits `ERC20PresetMinterPauser` of OpenZeppelin. The token name is "ClassToken", symbol is "CLT". 

Initial supply of this token will be set in deployment script. Initial supply of CLT will be sent to (mint to) deployer's address.

Compile smart contract by running:
```
yarn hardhat compile
```

### Task 1.3 Write Unit Test for smart contract

Unit test of smart contract is a must. We should cover smart contract with unit test as much as possible. The following script is included here to illustrate that we can't skip this step.

Add "test/ClassToken.ts":
```js
import { expect } from "chai";
import { ethers } from "hardhat";

describe("ClassToken", function () {
  it("Should have the correct initial supply", async function () {
    const initialSupply = ethers.utils.parseEther('10000')
    const ClassToken = await ethers.getContractFactory("ClassToken");
    const token = await ClassToken.deploy(initialSupply);
    await token.deployed();

    expect(await token.totalSupply()).to.equal(initialSupply);
  });
});
```

Run test:
```
yarn hardhat test
```

Unit test passed. We will try to deploy it to a local testnet.

---

## Task 2: Deploy smart contract to local testnet

We will deploy smart contract both to in-process and stand-alone local testnet to display usage and difference between these two.

### Task 2.1: Write deployment script

Add "scripts/deploy_classtoken.ts": 
```js
import { ethers } from "hardhat";

async function main() {

  const initialSupply = ethers.utils.parseEther('10000')
  const ClassToken = await ethers.getContractFactory("ClassToken");
  const token = await ClassToken.deploy(initialSupply);
  await token.deployed();

  console.log("ClassToken deployed to:", token.address);
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
```

The `intialSupply` is set to be 10000.0 CLS. 

### 2.2 deploy on in-process local testnet.
 
```
yarn hardhat run scripts/deploy_classtoken.ts
//ClassToken deployed to: 0x5FbDB2315678afecb367f032d93F642f64180aa3
```

If you run the script again, you will find the smart contract is always deployed to the same address as in-process is new every time.

### 2.3 Run a stand-alone local testnet

Run a stand-alone local testnet at another terminal:
```
yarn hardhat node
```

### 2.4 Deploy ClassToken to stand-alone local testnet

Deploy smart contract:
```
yarn hardhat run scripts/deploy_classtoken.ts --network localhost
//ClassToken deployed to: 0x5FbDB2315678afecb367f032d93F642f64180aa3
```

If you run the script again, you will find the smart contract is deployed to a new address:
```
yarn hardhat run scripts/deploy_classtoken.ts --network localhost
//ClassToken deployed to: 0xe7f1725E7734CE288F8367e1Bb143E90bb3F0512
```

We will use the smart contract instance at: `0xe7f1725E7734CE288F8367e1Bb143E90bb3F0512`

---


## Task 3: Interact with smart contract from console

### Task 3.1 Get smart contract instance

Run console connecting to stand-alone local testnet:
```
yarn hardhat console --network localhost
```

Get Smart contract:

```js
const address = '0xe7f1725E7734CE288F8367e1Bb143E90bb3F0512';
const token = await ethers.getContractAt("ClassToken", address);
```

### Task 3.2 Get to know properties smart contract

Docs can be found at: https://docs.ethers.io/v5/api/contract/contract/#Contract--properties

```js
token.interaface
token.provider
token.signer

token.signer.address
//'0xf39Fd6e51aad88F6F4ce6aB8827279cffFb92266'
```

### Task 3.3 Get data from smart contract

```js
parseEther =ethers.utils.parseEther
formatEther = ethers.utils.formatEther
await token.totalSupply().then((r)=>console.log(formatEther(r)))
//10000.0

await token.symbol()
//CLT
await token.name()
//ClassToken
```

### Task 3.4 Token balance of deployer

```js
deployer='0xf39fd6e51aad88f6f4ce6ab8827279cfffb92266'
await token.balanceOf(deployer).then((r)=>console.log(formatEther(r)))
//10000.0
```

### Task 3.5 Transfer Token from deployer to other

We will transfer CLS token by calling `transfer()` of ERC20 standard. You can also send ERC20 token using MeteMask in two steps: 1) add token using token address(contract address), 2) send some amount of it to other's address.

```js
to_address='0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1'
await token.transfer(to_address,parseEther('1000'))

await token.balanceOf(to_address).then((r)=>console.log(formatEther(r)))
//1000.0
```

Now, only user with the correct private key of the address can use this token in address `0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1`. 

---

## Task 4: Connect wallet and transfer token

Note: you can refer to the second part of this tutorial "Understanding Blockchain with `ethers.js`: 4 Tasks of wallet" to know more about wallet usage.


### Task 4.1 Create wallet 

```js
//account not in hardhat default
privateKey='0x4f3edf983ac636a65a842ce7c78d9aa706d3b113bce9c46f30d7d21715b23b1d'
wallet = new ethers.Wallet(privateKey)

wallet.address
//'0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1'
```


### Task 4.2 Send ethers from account 0 for gas fee usage

If adress `0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1` has no test ETH, it will not have the ability to send transactions. 

Do remember to send some ETH to this address for gas usage. If it has test ETH, you can skip this step Task 4.2.

```js
signer = await ethers.provider.getSigner()
send_address = await signer.getAddress()

to_address = wallet.address
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
await ethers.provider.getBalance(wallet.address).then(result=>ethers.utils.formatEther(result))
//'1.0'
```

### Task 4.4 Connect wallet to provider

Connect wallet to provider

```js
walletsigner = wallet.connect(ethers.provider)
walletsigner.address
//still be the one
```

### Task 4.5 Set walletsigner as signer of ClassToken

```js
newtokeninstance = await token.connect(walletsigner)
newtokeninstance.signer.address
//'0x90F8bf6A479f320ead074411a4B0e7944Ea8c9C1'
```

### Task 4.6 send ClassToken from this address 

```js
deployer='0xf39fd6e51aad88f6f4ce6ab8827279cfffb92266'
await newtokeninstance.transfer(deployer,parseEther('66'))
```

Do read  the returned receipt of this contract method call. 

Let's check whether we get the correct result:
```js
await token.balanceOf(deployer).then((r)=>console.log(formatEther(r)))
//9066.0
await token.balanceOf(to_address).then((r)=>console.log(formatEther(r)))
//934.0
```

After going through 12 tasks in this tutorial, you can begin to use `Ethers.js` in Web3 development. `Ethers.js`, as well as `web3.js`, is very important as it stands at the overlapped space between blockchain and web App.

---


If you find this note useful, please follow my twitter [@fjun99](https://twitter.com/fjun99).

---