# configuration
MAIN:=hotdrink.js

##################################################
# helper functions

hide=$(dir $1).$(notdir $1)
unhide=$(dir $1)$(patsubst .%,%,$(notdir $1))

##################################################
# optional configuration

INCDIRS:=
LIBDIRS:=

SRCDIR:=lib
#SOURCES:=$(shell find $(SRCDIR) -name '*.js' -print)
SOURCES:=\
	utility/prototype-form-ex.js \
	utility/debug.js \
	utility/stdlib.js \
	utility/namespace.js \
	concept/model/value.js \
	concept/model/behavior.js \
	concept/view/behavior.js \
	concept/view/bind.js \
	graph/cgraph.js \
	graph/sgraph.js \
	graph/solver.js \
	graph/egraph.js \
	graph/evaluator.js \
	behavior/enablement.js \
	model.js \
	controller/model.js \
	controller/factory.js \
	controller/behavior/value.js \
	controller/behavior/enablement.js \
	controller/view/html/find.js \
	controller/view/html/value.js \
	controller/view/html/enablement.js \
	controller.js \
	parser/parsec.js \
	parser/expr_parser.js \
	parser/model_parser.js \
	driver.js
SOURCES:=$(addprefix $(SRCDIR)/,$(SOURCES))

#THIRD_PARTY_SOURCES:=\
	#third_party/prototype.js
#THIRD_PARTY_SOURCES:=$(addprefix $(SRCDIR)/,$(THIRD_PARTY_SOURCES))

# macros are defined in headers
HEADERS:=\
  utility/debug.m4.js
HEADERS:=$(addprefix $(SRCDIR)/,$(HEADERS))

OBJDIR:=build
DOCDIR:=doc

RELEASE_FLAGS:=
DEBUG_FLAGS:=-DDEBUG

BUILD_FLAGS:=$(DEBUG_FLAGS)
#BUILD_FLAGS:=$(RELEASE_FLAGS)

# Change the path to the YUI Compressor as necessary:
#YUIC:=java -jar $(HOME)/local/bin/yuicompressor-2.4.2.jar --type js
# If you do not have the YUI Compressor installed:
YUIC:=cat

M4:=m4
M4FLAGS:=-P $(BUILD_FLAGS)

##################################################
# self configuration (do not touch)

OBJECTS:=$(SOURCES:$(SRCDIR)/%=$(OBJDIR)/%)

##################################################
# targets

.PHONY : all doc debug

all : $(MAIN)

$(MAIN) : $(OBJECTS)
	cat $^ > /tmp/$@
	$(YUIC) /tmp/$@ > $@

doc :
	jsdoc -d=$(DOCDIR) $(SOURCES)

debug :
#	@echo "OBJECTS:=$(OBJECTS)"

##################################################
# objects

# For some reason, the stem does not work properly in the order-only
# prerequisite, so this rule had to be moved to second expansion
#$(OBJECTS) : $(OBJDIR)/% : $(HEADERS) $(SRCDIR)/% | $(OBJDIR)/$(dir %)

$(OBJDIR)/% :
	mkdir -p $@

##################################################
# cleaning

.PHONY : clean clean-obj clean-exe clean-doc

clean : clean-obj clean-exe clean-doc

clean-exe :
	-rm -f $(MAIN)

clean-obj :
	-rm -rf $(OBJDIR)

clean-doc :
	-rm -rf $(DOCDIR)

##################################################
# secondary expansion

.SECONDEXPANSION:

##################################################
# objects

# Have to replace default rule because of separate build directory.
# Unnecessary if make created the directory when writing a file.
$(OBJECTS) : $(OBJDIR)/% : $(HEADERS) $(SRCDIR)/% | $$(@D)
	$(M4) $(M4FLAGS) $^ > $@
