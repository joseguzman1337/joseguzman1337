// des
// this takes the key, the message, and whether to encrypt or decrypt
function des (key, message, encrypt, mode, iv) {
  // declaring this locally speeds things up a bit
  const spfunction1 = new Array(
    0x1010400,
    0,
    0x10000,
    0x1010404,
    0x1010004,
    0x10404,
    0x4,
    0x10000,
    0x400,
    0x1010400,
    0x1010404,
    0x400,
    0x1000404,
    0x1010004,
    0x1000000,
    0x4,
    0x404,
    0x1000400,
    0x1000400,
    0x10400,
    0x10400,
    0x1010000,
    0x1010000,
    0x1000404,
    0x10004,
    0x1000004,
    0x1000004,
    0x10004,
    0,
    0x404,
    0x10404,
    0x1000000,
    0x10000,
    0x1010404,
    0x4,
    0x1010000,
    0x1010400,
    0x1000000,
    0x1000000,
    0x400,
    0x1010004,
    0x10000,
    0x10400,
    0x1000004,
    0x400,
    0x4,
    0x1000404,
    0x10404,
    0x1010404,
    0x10004,
    0x1010000,
    0x1000404,
    0x1000004,
    0x404,
    0x10404,
    0x1010400,
    0x404,
    0x1000400,
    0x1000400,
    0,
    0x10004,
    0x10400,
    0,
    0x1010004
  )
  const spfunction2 = new Array(
    0x80108020,
    0x80008000,
    0x8000,
    0x108020,
    0x100000,
    0x20,
    0x80100020,
    0x80008020,
    0x80000020,
    0x80108020,
    0x80108000,
    0x80000000,
    0x80008000,
    0x100000,
    0x20,
    0x80100020,
    0x108000,
    0x100020,
    0x80008020,
    0,
    0x80000000,
    0x8000,
    0x108020,
    0x80100000,
    0x100020,
    0x80000020,
    0,
    0x108000,
    0x8020,
    0x80108000,
    0x80100000,
    0x8020,
    0,
    0x108020,
    0x80100020,
    0x100000,
    0x80008020,
    0x80100000,
    0x80108000,
    0x8000,
    0x80100000,
    0x80008000,
    0x20,
    0x80108020,
    0x108020,
    0x20,
    0x8000,
    0x80000000,
    0x8020,
    0x80108000,
    0x100000,
    0x80000020,
    0x100020,
    0x80008020,
    0x80000020,
    0x100020,
    0x108000,
    0,
    0x80008000,
    0x8020,
    0x80000000,
    0x80100020,
    0x80108020,
    0x108000
  )
  const spfunction3 = new Array(
    0x208,
    0x8020200,
    0,
    0x8020008,
    0x8000200,
    0,
    0x20208,
    0x8000200,
    0x20008,
    0x8000008,
    0x8000008,
    0x20000,
    0x8020208,
    0x20008,
    0x8020000,
    0x208,
    0x8000000,
    0x8,
    0x8020200,
    0x200,
    0x20200,
    0x8020000,
    0x8020008,
    0x20208,
    0x8000208,
    0x20200,
    0x20000,
    0x8000208,
    0x8,
    0x8020208,
    0x200,
    0x8000000,
    0x8020200,
    0x8000000,
    0x20008,
    0x208,
    0x20000,
    0x8020200,
    0x8000200,
    0,
    0x200,
    0x20008,
    0x8020208,
    0x8000200,
    0x8000008,
    0x200,
    0,
    0x8020008,
    0x8000208,
    0x20000,
    0x8000000,
    0x8020208,
    0x8,
    0x20208,
    0x20200,
    0x8000008,
    0x8020000,
    0x8000208,
    0x208,
    0x8020000,
    0x20208,
    0x8,
    0x8020008,
    0x20200
  )
  const spfunction4 = new Array(
    0x802001,
    0x2081,
    0x2081,
    0x80,
    0x802080,
    0x800081,
    0x800001,
    0x2001,
    0,
    0x802000,
    0x802000,
    0x802081,
    0x81,
    0,
    0x800080,
    0x800001,
    0x1,
    0x2000,
    0x800000,
    0x802001,
    0x80,
    0x800000,
    0x2001,
    0x2080,
    0x800081,
    0x1,
    0x2080,
    0x800080,
    0x2000,
    0x802080,
    0x802081,
    0x81,
    0x800080,
    0x800001,
    0x802000,
    0x802081,
    0x81,
    0,
    0,
    0x802000,
    0x2080,
    0x800080,
    0x800081,
    0x1,
    0x802001,
    0x2081,
    0x2081,
    0x80,
    0x802081,
    0x81,
    0x1,
    0x2000,
    0x800001,
    0x2001,
    0x802080,
    0x800081,
    0x2001,
    0x2080,
    0x800000,
    0x802001,
    0x80,
    0x800000,
    0x2000,
    0x802080
  )
  const spfunction5 = new Array(
    0x100,
    0x2080100,
    0x2080000,
    0x42000100,
    0x80000,
    0x100,
    0x40000000,
    0x2080000,
    0x40080100,
    0x80000,
    0x2000100,
    0x40080100,
    0x42000100,
    0x42080000,
    0x80100,
    0x40000000,
    0x2000000,
    0x40080000,
    0x40080000,
    0,
    0x40000100,
    0x42080100,
    0x42080100,
    0x2000100,
    0x42080000,
    0x40000100,
    0,
    0x42000000,
    0x2080100,
    0x2000000,
    0x42000000,
    0x80100,
    0x80000,
    0x42000100,
    0x100,
    0x2000000,
    0x40000000,
    0x2080000,
    0x42000100,
    0x40080100,
    0x2000100,
    0x40000000,
    0x42080000,
    0x2080100,
    0x40080100,
    0x100,
    0x2000000,
    0x42080000,
    0x42080100,
    0x80100,
    0x42000000,
    0x42080100,
    0x2080000,
    0,
    0x40080000,
    0x42000000,
    0x80100,
    0x2000100,
    0x40000100,
    0x80000,
    0,
    0x40080000,
    0x2080100,
    0x40000100
  )
  const spfunction6 = new Array(
    0x20000010,
    0x20400000,
    0x4000,
    0x20404010,
    0x20400000,
    0x10,
    0x20404010,
    0x400000,
    0x20004000,
    0x404010,
    0x400000,
    0x20000010,
    0x400010,
    0x20004000,
    0x20000000,
    0x4010,
    0,
    0x400010,
    0x20004010,
    0x4000,
    0x404000,
    0x20004010,
    0x10,
    0x20400010,
    0x20400010,
    0,
    0x404010,
    0x20404000,
    0x4010,
    0x404000,
    0x20404000,
    0x20000000,
    0x20004000,
    0x10,
    0x20400010,
    0x404000,
    0x20404010,
    0x400000,
    0x4010,
    0x20000010,
    0x400000,
    0x20004000,
    0x20000000,
    0x4010,
    0x20000010,
    0x20404010,
    0x404000,
    0x20400000,
    0x404010,
    0x20404000,
    0,
    0x20400010,
    0x10,
    0x4000,
    0x20400000,
    0x404010,
    0x4000,
    0x400010,
    0x20004010,
    0,
    0x20404000,
    0x20000000,
    0x400010,
    0x20004010
  )
  const spfunction7 = new Array(
    0x200000,
    0x4200002,
    0x4000802,
    0,
    0x800,
    0x4000802,
    0x200802,
    0x4200800,
    0x4200802,
    0x200000,
    0,
    0x4000002,
    0x2,
    0x4000000,
    0x4200002,
    0x802,
    0x4000800,
    0x200802,
    0x200002,
    0x4000800,
    0x4000002,
    0x4200000,
    0x4200800,
    0x200002,
    0x4200000,
    0x800,
    0x802,
    0x4200802,
    0x200800,
    0x2,
    0x4000000,
    0x200800,
    0x4000000,
    0x200800,
    0x200000,
    0x4000802,
    0x4000802,
    0x4200002,
    0x4200002,
    0x2,
    0x200002,
    0x4000000,
    0x4000800,
    0x200000,
    0x4200800,
    0x802,
    0x200802,
    0x4200800,
    0x802,
    0x4000002,
    0x4200802,
    0x4200000,
    0x200800,
    0,
    0x2,
    0x4200802,
    0,
    0x200802,
    0x4200000,
    0x800,
    0x4000002,
    0x4000800,
    0x800,
    0x200002
  )
  const spfunction8 = new Array(
    0x10001040,
    0x1000,
    0x40000,
    0x10041040,
    0x10000000,
    0x10001040,
    0x40,
    0x10000000,
    0x40040,
    0x10040000,
    0x10041040,
    0x41000,
    0x10041000,
    0x41040,
    0x1000,
    0x40,
    0x10040000,
    0x10000040,
    0x10001000,
    0x1040,
    0x41000,
    0x40040,
    0x10040040,
    0x10041000,
    0x1040,
    0,
    0,
    0x10040040,
    0x10000040,
    0x10001000,
    0x41040,
    0x40000,
    0x41040,
    0x40000,
    0x10041000,
    0x1000,
    0x40,
    0x10040040,
    0x1000,
    0x41040,
    0x10001000,
    0x40,
    0x10000040,
    0x10040000,
    0x10040040,
    0x10000000,
    0x40000,
    0x10001040,
    0,
    0x10041040,
    0x40040,
    0x10000040,
    0x10040000,
    0x10001000,
    0x10001040,
    0,
    0x10041040,
    0x41000,
    0x41000,
    0x1040,
    0x1040,
    0x40040,
    0x10000000,
    0x10041000
  )

  // create the 16 or 48 subkeys we will need
  const keys = des_createKeys(key)
  let m = 0
  let i
  let j
  let temp
  let temp2
  let right1
  let right2
  let left
  let right
  let looping
  let cbcleft, cbcleft2, cbcright, cbcright2
  let endloop, loopinc
  const len = message.length
  let chunk = 0
  // set up the loops for single and triple des
  const iterations = keys.length == 32 ? 3 : 9 // single or triple des
  if (iterations == 3) {
    looping = encrypt ? new Array(0, 32, 2) : new Array(30, -2, -2)
  } else {
    looping = encrypt
      ? new Array(0, 32, 2, 62, 30, -2, 64, 96, 2)
      : new Array(94, 62, -2, 32, 64, 2, 30, -2, -2)
  }

  message += '\0\0\0\0\0\0\0\0' // pad the message out with null bytes
  // store the result here
  result = ''
  tempresult = ''

  if (mode == 1) {
    // CBC mode
    cbcleft =
      (iv.charCodeAt(m++) << 24) |
      (iv.charCodeAt(m++) << 16) |
      (iv.charCodeAt(m++) << 8) |
      iv.charCodeAt(m++)
    cbcright =
      (iv.charCodeAt(m++) << 24) |
      (iv.charCodeAt(m++) << 16) |
      (iv.charCodeAt(m++) << 8) |
      iv.charCodeAt(m++)
    m = 0
  }

  // loop through each 64 bit chunk of the message
  while (m < len) {
    left =
      (message.charCodeAt(m++) << 24) |
      (message.charCodeAt(m++) << 16) |
      (message.charCodeAt(m++) << 8) |
      message.charCodeAt(m++)
    right =
      (message.charCodeAt(m++) << 24) |
      (message.charCodeAt(m++) << 16) |
      (message.charCodeAt(m++) << 8) |
      message.charCodeAt(m++)

    // for Cipher Block Chaining mode, xor the message with the previous result
    if (mode == 1) {
      if (encrypt) {
        left ^= cbcleft
        right ^= cbcright
      } else {
        cbcleft2 = cbcleft
        cbcright2 = cbcright
        cbcleft = left
        cbcright = right
      }
    }

    // first each 64 but chunk of the message must be permuted according to IP
    temp = ((left >>> 4) ^ right) & 0x0f0f0f0f
    right ^= temp
    left ^= temp << 4
    temp = ((left >>> 16) ^ right) & 0x0000ffff
    right ^= temp
    left ^= temp << 16
    temp = ((right >>> 2) ^ left) & 0x33333333
    left ^= temp
    right ^= temp << 2
    temp = ((right >>> 8) ^ left) & 0x00ff00ff
    left ^= temp
    right ^= temp << 8
    temp = ((left >>> 1) ^ right) & 0x55555555
    right ^= temp
    left ^= temp << 1

    left = (left << 1) | (left >>> 31)
    right = (right << 1) | (right >>> 31)

    // do this either 1 or 3 times for each chunk of the message
    for (j = 0; j < iterations; j += 3) {
      endloop = looping[j + 1]
      loopinc = looping[j + 2]
      // now go through and perform the encryption or decryption
      for (i = looping[j]; i != endloop; i += loopinc) {
        // for efficiency
        right1 = right ^ keys[i]
        right2 = ((right >>> 4) | (right << 28)) ^ keys[i + 1]
        // the result is attained by passing these bytes through the S selection functions
        temp = left
        left = right
        right =
          temp ^
          (spfunction2[(right1 >>> 24) & 0x3f] |
            spfunction4[(right1 >>> 16) & 0x3f] |
            spfunction6[(right1 >>> 8) & 0x3f] |
            spfunction8[right1 & 0x3f] |
            spfunction1[(right2 >>> 24) & 0x3f] |
            spfunction3[(right2 >>> 16) & 0x3f] |
            spfunction5[(right2 >>> 8) & 0x3f] |
            spfunction7[right2 & 0x3f])
      }
      temp = left
      left = right
      right = temp // unreverse left and right
    } // for either 1 or 3 iterations

    // move then each one bit to the right
    left = (left >>> 1) | (left << 31)
    right = (right >>> 1) | (right << 31)

    // now perform IP-1, which is IP in the opposite direction
    temp = ((left >>> 1) ^ right) & 0x55555555
    right ^= temp
    left ^= temp << 1
    temp = ((right >>> 8) ^ left) & 0x00ff00ff
    left ^= temp
    right ^= temp << 8
    temp = ((right >>> 2) ^ left) & 0x33333333
    left ^= temp
    right ^= temp << 2
    temp = ((left >>> 16) ^ right) & 0x0000ffff
    right ^= temp
    left ^= temp << 16
    temp = ((left >>> 4) ^ right) & 0x0f0f0f0f
    right ^= temp
    left ^= temp << 4

    // for Cipher Block Chaining mode, xor the message with the previous result
    if (mode == 1) {
      if (encrypt) {
        cbcleft = left
        cbcright = right
      } else {
        left ^= cbcleft2
        right ^= cbcright2
      }
    }
    tempresult += String.fromCharCode(
      left >>> 24,
      (left >>> 16) & 0xff,
      (left >>> 8) & 0xff,
      left & 0xff,
      right >>> 24,
      (right >>> 16) & 0xff,
      (right >>> 8) & 0xff,
      right & 0xff
    )

    chunk += 8
    if (chunk == 512) {
      result += tempresult
      tempresult = ''
      chunk = 0
    }
  } // for every 8 characters, or 64 bits in the message

  // return the result as an array
  return result + tempresult
} // end of des

// des_createKeys
// this takes as input a 64 bit key (even though only 56 bits are used)
// as an array of 2 integers, and returns 16 48 bit keys
function des_createKeys (key) {
  // declaring this locally speeds things up a bit
  pc2bytes0 = new Array(
    0,
    0x4,
    0x20000000,
    0x20000004,
    0x10000,
    0x10004,
    0x20010000,
    0x20010004,
    0x200,
    0x204,
    0x20000200,
    0x20000204,
    0x10200,
    0x10204,
    0x20010200,
    0x20010204
  )
  pc2bytes1 = new Array(
    0,
    0x1,
    0x100000,
    0x100001,
    0x4000000,
    0x4000001,
    0x4100000,
    0x4100001,
    0x100,
    0x101,
    0x100100,
    0x100101,
    0x4000100,
    0x4000101,
    0x4100100,
    0x4100101
  )
  pc2bytes2 = new Array(
    0,
    0x8,
    0x800,
    0x808,
    0x1000000,
    0x1000008,
    0x1000800,
    0x1000808,
    0,
    0x8,
    0x800,
    0x808,
    0x1000000,
    0x1000008,
    0x1000800,
    0x1000808
  )
  pc2bytes3 = new Array(
    0,
    0x200000,
    0x8000000,
    0x8200000,
    0x2000,
    0x202000,
    0x8002000,
    0x8202000,
    0x20000,
    0x220000,
    0x8020000,
    0x8220000,
    0x22000,
    0x222000,
    0x8022000,
    0x8222000
  )
  pc2bytes4 = new Array(
    0,
    0x40000,
    0x10,
    0x40010,
    0,
    0x40000,
    0x10,
    0x40010,
    0x1000,
    0x41000,
    0x1010,
    0x41010,
    0x1000,
    0x41000,
    0x1010,
    0x41010
  )
  pc2bytes5 = new Array(
    0,
    0x400,
    0x20,
    0x420,
    0,
    0x400,
    0x20,
    0x420,
    0x2000000,
    0x2000400,
    0x2000020,
    0x2000420,
    0x2000000,
    0x2000400,
    0x2000020,
    0x2000420
  )
  pc2bytes6 = new Array(
    0,
    0x10000000,
    0x80000,
    0x10080000,
    0x2,
    0x10000002,
    0x80002,
    0x10080002,
    0,
    0x10000000,
    0x80000,
    0x10080000,
    0x2,
    0x10000002,
    0x80002,
    0x10080002
  )
  pc2bytes7 = new Array(
    0,
    0x10000,
    0x800,
    0x10800,
    0x20000000,
    0x20010000,
    0x20000800,
    0x20010800,
    0x20000,
    0x30000,
    0x20800,
    0x30800,
    0x20020000,
    0x20030000,
    0x20020800,
    0x20030800
  )
  pc2bytes8 = new Array(
    0,
    0x40000,
    0,
    0x40000,
    0x2,
    0x40002,
    0x2,
    0x40002,
    0x2000000,
    0x2040000,
    0x2000000,
    0x2040000,
    0x2000002,
    0x2040002,
    0x2000002,
    0x2040002
  )
  pc2bytes9 = new Array(
    0,
    0x10000000,
    0x8,
    0x10000008,
    0,
    0x10000000,
    0x8,
    0x10000008,
    0x400,
    0x10000400,
    0x408,
    0x10000408,
    0x400,
    0x10000400,
    0x408,
    0x10000408
  )
  pc2bytes10 = new Array(
    0,
    0x20,
    0,
    0x20,
    0x100000,
    0x100020,
    0x100000,
    0x100020,
    0x2000,
    0x2020,
    0x2000,
    0x2020,
    0x102000,
    0x102020,
    0x102000,
    0x102020
  )
  pc2bytes11 = new Array(
    0,
    0x1000000,
    0x200,
    0x1000200,
    0x200000,
    0x1200000,
    0x200200,
    0x1200200,
    0x4000000,
    0x5000000,
    0x4000200,
    0x5000200,
    0x4200000,
    0x5200000,
    0x4200200,
    0x5200200
  )
  pc2bytes12 = new Array(
    0,
    0x1000,
    0x8000000,
    0x8001000,
    0x80000,
    0x81000,
    0x8080000,
    0x8081000,
    0x10,
    0x1010,
    0x8000010,
    0x8001010,
    0x80010,
    0x81010,
    0x8080010,
    0x8081010
  )
  pc2bytes13 = new Array(
    0,
    0x4,
    0x100,
    0x104,
    0,
    0x4,
    0x100,
    0x104,
    0x1,
    0x5,
    0x101,
    0x105,
    0x1,
    0x5,
    0x101,
    0x105
  )

  // how many iterations (1 for des, 3 for triple des)
  const iterations = key.length >= 24 ? 3 : 1
  // stores the return keys
  const keys = new Array(32 * iterations)
  // now define the left shifts which need to be done
  const shifts = new Array(0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0)
  // other variables
  let lefttemp
  let righttemp
  let m = 0
  let n = 0
  let temp

  for (let j = 0; j < iterations; j++) {
    // either 1 or 3 iterations
    left =
      (key.charCodeAt(m++) << 24) |
      (key.charCodeAt(m++) << 16) |
      (key.charCodeAt(m++) << 8) |
      key.charCodeAt(m++)
    right =
      (key.charCodeAt(m++) << 24) |
      (key.charCodeAt(m++) << 16) |
      (key.charCodeAt(m++) << 8) |
      key.charCodeAt(m++)

    temp = ((left >>> 4) ^ right) & 0x0f0f0f0f
    right ^= temp
    left ^= temp << 4
    temp = ((right >>> -16) ^ left) & 0x0000ffff
    left ^= temp
    right ^= temp << -16
    temp = ((left >>> 2) ^ right) & 0x33333333
    right ^= temp
    left ^= temp << 2
    temp = ((right >>> -16) ^ left) & 0x0000ffff
    left ^= temp
    right ^= temp << -16
    temp = ((left >>> 1) ^ right) & 0x55555555
    right ^= temp
    left ^= temp << 1
    temp = ((right >>> 8) ^ left) & 0x00ff00ff
    left ^= temp
    right ^= temp << 8
    temp = ((left >>> 1) ^ right) & 0x55555555
    right ^= temp
    left ^= temp << 1

    // the right side needs to be shifted and to get the last four bits of the left side
    temp = (left << 8) | ((right >>> 20) & 0x000000f0)
    // left needs to be put upside down
    left =
      (right << 24) |
      ((right << 8) & 0xff0000) |
      ((right >>> 8) & 0xff00) |
      ((right >>> 24) & 0xf0)
    right = temp

    // now go through and perform these shifts on the left and right keys
    for (i = 0; i < shifts.length; i++) {
      // shift the keys either one or two bits to the left
      if (shifts[i]) {
        left = (left << 2) | (left >>> 26)
        right = (right << 2) | (right >>> 26)
      } else {
        left = (left << 1) | (left >>> 27)
        right = (right << 1) | (right >>> 27)
      }
      left &= 0xfffffff0
      right &= 0xfffffff0

      // now apply PC-2, in such a way that E is easier when encrypting or decrypting
      // this conversion will look like PC-2 except only the last 6 bits of each byte are used
      // rather than 48 consecutive bits and the order of lines will be according to
      // how the S selection functions will be applied: S2, S4, S6, S8, S1, S3, S5, S7
      lefttemp =
        pc2bytes0[left >>> 28] |
        pc2bytes1[(left >>> 24) & 0xf] |
        pc2bytes2[(left >>> 20) & 0xf] |
        pc2bytes3[(left >>> 16) & 0xf] |
        pc2bytes4[(left >>> 12) & 0xf] |
        pc2bytes5[(left >>> 8) & 0xf] |
        pc2bytes6[(left >>> 4) & 0xf]
      righttemp =
        pc2bytes7[right >>> 28] |
        pc2bytes8[(right >>> 24) & 0xf] |
        pc2bytes9[(right >>> 20) & 0xf] |
        pc2bytes10[(right >>> 16) & 0xf] |
        pc2bytes11[(right >>> 12) & 0xf] |
        pc2bytes12[(right >>> 8) & 0xf] |
        pc2bytes13[(right >>> 4) & 0xf]
      temp = ((righttemp >>> 16) ^ lefttemp) & 0x0000ffff
      keys[n++] = lefttemp ^ temp
      keys[n++] = righttemp ^ (temp << 16)
    }
  } // for each iterations
  // return the keys we've created
  return keys
} // end of des_createKeys

// printHexArray
function printHex (s) {
  let r = ''
  const hexes = new Array(
    '0',
    '1',
    '2',
    '3',
    '4',
    '5',
    '6',
    '7',
    '8',
    '9',
    'a',
    'b',
    'c',
    'd',
    'e',
    'f'
  )
  for (let i = 0; i < s.length; i++) {
    r += hexes[s.charCodeAt(i) >> 4] + hexes[s.charCodeAt(i) & 0xf]
  }
  return r
}

function printDec (s) {
  let r = ''
  for (let i = 0; i < s.length; i++) {
    r += s.charCodeAt(i)
    r += ':'
  }
  return r
}

/// /////////////////////// END DES IMPLEMENTATION //////////////////////

function array (n) {
  for (i = 0; i < n; i++) this[i] = 0
  this.length = n
}

function integer (n) {
  return n % (0xffffffff + 1)
}

function shr (a, b) {
  a = integer(a)
  b = integer(b)
  if (a - 0x80000000 >= 0) {
    a = a % 0x80000000
    a >>= b
    a += 0x40000000 >> (b - 1)
  } else a >>= b
  return a
}

function shl1 (a) {
  a = a % 0x80000000
  if (a & (0x40000000 === 0x40000000)) {
    a -= 0x40000000
    a *= 2
    a += 0x80000000
  } else a *= 2
  return a
}

function shl (a, b) {
  a = integer(a)
  b = integer(b)
  for (let i = 0; i < b; i++) a = shl1(a)
  return a
}

function and (a, b) {
  a = integer(a)
  b = integer(b)
  const t1 = a - 0x80000000
  const t2 = b - 0x80000000
  if (t1 >= 0) return t2 >= 0 ? (t1 & t2) + 0x80000000 : t1 & b
  else if (t2 >= 0) return a & t2
  else return a & b
}

function or (a, b) {
  a = integer(a)
  b = integer(b)
  const t1 = a - 0x80000000
  const t2 = b - 0x80000000
  if (t1 >= 0) return t2 >= 0 ? (t1 | t2) + 0x80000000 : (t1 | b) + 0x80000000
  else if (t2 >= 0) return (a | t2) + 0x80000000
  else return a | b
}

function xor (a, b) {
  a = integer(a)
  b = integer(b)
  const t1 = a - 0x80000000
  const t2 = b - 0x80000000
  if (t1 >= 0) return t2 >= 0 ? t1 ^ t2 : (t1 ^ b) + 0x80000000
  else if (t2 >= 0) return (a ^ t2) + 0x80000000
  else return a ^ b
}

function not (a) {
  a = integer(a)
  return 0xffffffff - a
}

/* Here begin the real algorithm */

const state = new array(4)
const count = new array(2)
count[0] = 0
count[1] = 0
const buffer = new array(64)
const transformBuffer = new array(16)
const digestBits = new array(16)

const S11 = 7
const S12 = 12
const S13 = 17
const S14 = 22
const S21 = 5
const S22 = 9
const S23 = 14
const S24 = 20
const S31 = 4
const S32 = 11
const S33 = 16
const S34 = 23
const S41 = 6
const S42 = 10
const S43 = 15
const S44 = 21

function F (x, y, z) {
  return or(and(x, y), and(not(x), z))
}

function G (x, y, z) {
  return or(and(x, z), and(y, not(z)))
}

function H (x, y, z) {
  return xor(xor(x, y), z)
}

function I (x, y, z) {
  return xor(y, or(x, not(z)))
}

function rotateLeft (a, n) {
  return or(shl(a, n), shr(a, 32 - n))
}

function FF (a, b, c, d, x, s, ac) {
  a = a + F(b, c, d) + x + ac
  a = rotateLeft(a, s)
  a = a + b
  return a
}

function GG (a, b, c, d, x, s, ac) {
  a = a + G(b, c, d) + x + ac
  a = rotateLeft(a, s)
  a = a + b
  return a
}

function HH (a, b, c, d, x, s, ac) {
  a = a + H(b, c, d) + x + ac
  a = rotateLeft(a, s)
  a = a + b
  return a
}

function II (a, b, c, d, x, s, ac) {
  a = a + I(b, c, d) + x + ac
  a = rotateLeft(a, s)
  a = a + b
  return a
}

function transform (buf, offset) {
  let a = 0
  let b = 0
  let c = 0
  let d = 0
  const x = transformBuffer

  a = state[0]
  b = state[1]
  c = state[2]
  d = state[3]

  for (i = 0; i < 16; i++) {
    x[i] = and(buf[i * 4 + offset], 0xff)
    for (j = 1; j < 4; j++) {
      x[i] += shl(and(buf[i * 4 + j + offset], 0xff), j * 8)
    }
  }

  /* Round 1 */
  a = FF(a, b, c, d, x[0], S11, 0xd76aa478) /* 1 */
  d = FF(d, a, b, c, x[1], S12, 0xe8c7b756) /* 2 */
  c = FF(c, d, a, b, x[2], S13, 0x242070db) /* 3 */
  b = FF(b, c, d, a, x[3], S14, 0xc1bdceee) /* 4 */
  a = FF(a, b, c, d, x[4], S11, 0xf57c0faf) /* 5 */
  d = FF(d, a, b, c, x[5], S12, 0x4787c62a) /* 6 */
  c = FF(c, d, a, b, x[6], S13, 0xa8304613) /* 7 */
  b = FF(b, c, d, a, x[7], S14, 0xfd469501) /* 8 */
  a = FF(a, b, c, d, x[8], S11, 0x698098d8) /* 9 */
  d = FF(d, a, b, c, x[9], S12, 0x8b44f7af) /* 10 */
  c = FF(c, d, a, b, x[10], S13, 0xffff5bb1) /* 11 */
  b = FF(b, c, d, a, x[11], S14, 0x895cd7be) /* 12 */
  a = FF(a, b, c, d, x[12], S11, 0x6b901122) /* 13 */
  d = FF(d, a, b, c, x[13], S12, 0xfd987193) /* 14 */
  c = FF(c, d, a, b, x[14], S13, 0xa679438e) /* 15 */
  b = FF(b, c, d, a, x[15], S14, 0x49b40821) /* 16 */

  /* Round 2 */
  a = GG(a, b, c, d, x[1], S21, 0xf61e2562) /* 17 */
  d = GG(d, a, b, c, x[6], S22, 0xc040b340) /* 18 */
  c = GG(c, d, a, b, x[11], S23, 0x265e5a51) /* 19 */
  b = GG(b, c, d, a, x[0], S24, 0xe9b6c7aa) /* 20 */
  a = GG(a, b, c, d, x[5], S21, 0xd62f105d) /* 21 */
  d = GG(d, a, b, c, x[10], S22, 0x2441453) /* 22 */
  c = GG(c, d, a, b, x[15], S23, 0xd8a1e681) /* 23 */
  b = GG(b, c, d, a, x[4], S24, 0xe7d3fbc8) /* 24 */
  a = GG(a, b, c, d, x[9], S21, 0x21e1cde6) /* 25 */
  d = GG(d, a, b, c, x[14], S22, 0xc33707d6) /* 26 */
  c = GG(c, d, a, b, x[3], S23, 0xf4d50d87) /* 27 */
  b = GG(b, c, d, a, x[8], S24, 0x455a14ed) /* 28 */
  a = GG(a, b, c, d, x[13], S21, 0xa9e3e905) /* 29 */
  d = GG(d, a, b, c, x[2], S22, 0xfcefa3f8) /* 30 */
  c = GG(c, d, a, b, x[7], S23, 0x676f02d9) /* 31 */
  b = GG(b, c, d, a, x[12], S24, 0x8d2a4c8a) /* 32 */

  /* Round 3 */
  a = HH(a, b, c, d, x[5], S31, 0xfffa3942) /* 33 */
  d = HH(d, a, b, c, x[8], S32, 0x8771f681) /* 34 */
  c = HH(c, d, a, b, x[11], S33, 0x6d9d6122) /* 35 */
  b = HH(b, c, d, a, x[14], S34, 0xfde5380c) /* 36 */
  a = HH(a, b, c, d, x[1], S31, 0xa4beea44) /* 37 */
  d = HH(d, a, b, c, x[4], S32, 0x4bdecfa9) /* 38 */
  c = HH(c, d, a, b, x[7], S33, 0xf6bb4b60) /* 39 */
  b = HH(b, c, d, a, x[10], S34, 0xbebfbc70) /* 40 */
  a = HH(a, b, c, d, x[13], S31, 0x289b7ec6) /* 41 */
  d = HH(d, a, b, c, x[0], S32, 0xeaa127fa) /* 42 */
  c = HH(c, d, a, b, x[3], S33, 0xd4ef3085) /* 43 */
  b = HH(b, c, d, a, x[6], S34, 0x4881d05) /* 44 */
  a = HH(a, b, c, d, x[9], S31, 0xd9d4d039) /* 45 */
  d = HH(d, a, b, c, x[12], S32, 0xe6db99e5) /* 46 */
  c = HH(c, d, a, b, x[15], S33, 0x1fa27cf8) /* 47 */
  b = HH(b, c, d, a, x[2], S34, 0xc4ac5665) /* 48 */

  /* Round 4 */
  a = II(a, b, c, d, x[0], S41, 0xf4292244) /* 49 */
  d = II(d, a, b, c, x[7], S42, 0x432aff97) /* 50 */
  c = II(c, d, a, b, x[14], S43, 0xab9423a7) /* 51 */
  b = II(b, c, d, a, x[5], S44, 0xfc93a039) /* 52 */
  a = II(a, b, c, d, x[12], S41, 0x655b59c3) /* 53 */
  d = II(d, a, b, c, x[3], S42, 0x8f0ccc92) /* 54 */
  c = II(c, d, a, b, x[10], S43, 0xffeff47d) /* 55 */
  b = II(b, c, d, a, x[1], S44, 0x85845dd1) /* 56 */
  a = II(a, b, c, d, x[8], S41, 0x6fa87e4f) /* 57 */
  d = II(d, a, b, c, x[15], S42, 0xfe2ce6e0) /* 58 */
  c = II(c, d, a, b, x[6], S43, 0xa3014314) /* 59 */
  b = II(b, c, d, a, x[13], S44, 0x4e0811a1) /* 60 */
  a = II(a, b, c, d, x[4], S41, 0xf7537e82) /* 61 */
  d = II(d, a, b, c, x[11], S42, 0xbd3af235) /* 62 */
  c = II(c, d, a, b, x[2], S43, 0x2ad7d2bb) /* 63 */
  b = II(b, c, d, a, x[9], S44, 0xeb86d391) /* 64 */

  state[0] += a
  state[1] += b
  state[2] += c
  state[3] += d
}

function init () {
  count[0] = count[1] = 0
  state[0] = 0x67452301
  state[1] = 0xefcdab89
  state[2] = 0x98badcfe
  state[3] = 0x10325476
  for (i = 0; i < digestBits.length; i++) digestBits[i] = 0
}

function update (b) {
  let index, i

  index = and(shr(count[0], 3), 0x3f)
  if (count[0] < 0xffffffff - 7) count[0] += 8
  else {
    count[1]++
    count[0] -= 0xffffffff + 1
    count[0] += 8
  }
  buffer[index] = and(b, 0xff)
  if (index >= 63) {
    transform(buffer, 0)
  }
}

function finish () {
  const bits = new array(8)
  let padding
  let i = 0
  let index = 0
  let padLen = 0

  for (i = 0; i < 4; i++) {
    bits[i] = and(shr(count[0], i * 8), 0xff)
  }
  for (i = 0; i < 4; i++) {
    bits[i + 4] = and(shr(count[1], i * 8), 0xff)
  }
  index = and(shr(count[0], 3), 0x3f)
  padLen = index < 56 ? 56 - index : 120 - index
  padding = new array(64)
  padding[0] = 0x80
  for (i = 0; i < padLen; i++) update(padding[i])
  for (i = 0; i < 8; i++) update(bits[i])

  for (i = 0; i < 4; i++) {
    for (j = 0; j < 4; j++) {
      digestBits[i * 4 + j] = and(shr(state[i], j * 8), 0xff)
    }
  }
}

/* End of the MD5 algorithm */

function hexa (n) {
  const hexa_h = '0123456789abcdef'
  let hexa_c = ''
  let hexa_m = n
  for (hexa_i = 0; hexa_i < 8; hexa_i++) {
    hexa_c = hexa_h.charAt(Math.abs(hexa_m) % 16) + hexa_c
    hexa_m = Math.floor(hexa_m / 16)
  }
  return hexa_c
}

const ascii =
  '01234567890123456789012345678901' +
  " !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ" +
  '[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~'

function MD5 (entree) {
  let l, s, k, ka, kb, kc, kd

  init()
  for (k = 0; k < entree.length; k++) {
    l = entree.charAt(k)
    update(ascii.lastIndexOf(l))
  }
  finish()
  ka = kb = kc = kd = 0
  for (i = 0; i < 4; i++) ka += shl(digestBits[15 - i], i * 8)
  for (i = 4; i < 8; i++) kb += shl(digestBits[15 - i], (i - 4) * 8)
  for (i = 8; i < 12; i++) kc += shl(digestBits[15 - i], (i - 8) * 8)
  for (i = 12; i < 16; i++) kd += shl(digestBits[15 - i], (i - 12) * 8)
  s = hexa(kd) + hexa(kc) + hexa(kb) + hexa(ka)
  return s
}

function procesar () {
  const miPw = document.getElementById('Password').value
  const pwhash = MD5(miPw)
  const pw = pwhash.substring(0, 24)
  document.getElementById('Password').value = pw
  document.forms.form1.submit()
}

function process () {
  const miPw = document.getElementById('password').value
  let pwhash = MD5(miPw)
  let pw = pwhash.substring(0, 24)
  let message = document.forms.securemail.message.value
  const cipher = des(pw, message, 1)
  const hexcipher = printHex(cipher)
  document.forms.securemail.message.value = hexcipher
  document.forms.securemail.password.value = 'encrypted'
  message = ''
  pwhash = ''
  pw = ''
  document.forms.securemail.submit()
}

function decrypt () {
  const hexcipher = document.forms.deciphermail.message.value
  const pwhash = MD5(document.forms.deciphermail.password.value)
  const pw = pwhash.substring(0, 24)
  const hexlen = hexcipher.length
  let i
  let cipher = ''
  const onechar = ''
  let onehex = ''
  for (i = 1; i < hexlen; i = i + 2) {
    onehex = hexcipher.charAt(i - 1) + hexcipher.charAt(i)
    eval('onechar=unescape("%' + onehex + '");')
    cipher += onechar
  }
  document.forms.deciphermail.message.value = des(pw, cipher, 0)
}
